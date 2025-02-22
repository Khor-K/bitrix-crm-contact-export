<?php

namespace Khork\CrmEntityExport;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

abstract class AbstractExporter
{
    protected $entityName;
    protected $fieldLabels = [];

    public function __construct(string $entityName)
    {
        $this->entityName = $entityName;
    }

    abstract protected function fetchData(array $select, array $filter): array;

    abstract protected function fetchFieldLabels(): array;

    public function export(string $format, array $select = ['*', 'UF_*'], array $filter = []): void
    {
        $data = $this->fetchData($select, $filter);
        $this->fieldLabels = $this->fetchFieldLabels();

        if ($format === 'csv') {
            $this->exportCsv($data);
        } elseif ($format === 'xlsx') {
            $this->exportXlsx($data);
        } else {
            throw new \InvalidArgumentException("Unsupported export format: $format");
        }
    }

    protected function exportCsv(array $data): void
    {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $this->entityName . '.csv"');
        echo "\xEF\xBB\xBF"; // UTF-8
        $output = fopen('php://output', 'w');

        // Write headers
        $headers = [];
        foreach (array_keys($data[0]) as $field) {
            $headers[] = $this->fieldLabels[$field] ?? $field;
        }
        fputcsv($output, $headers, ';');

        // Write data
        foreach ($data as $row) {
            $rowData = [];
            foreach (array_keys($data[0]) as $field) {
                $textValue = 'Empty';

                if (!empty($row[$field])) {
                    if (is_array($row[$field])) {
                        $textValue = join(', ', $row[$field]);
                    } else {
                        $textValue = $row[$field];
                    }
                }

                $rowData[] = $textValue;
            }
            fputcsv($output, $rowData, ';');
        }
        fclose($output);
    }

    protected function exportXlsx(array $data): void
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/local/modules/khork.crmentityexport/vendor/autoload.php');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Write headers
        $column = 'A';
        foreach (array_keys($data[0]) as $field) {
            $sheet->setCellValue($column . '1', $this->fieldLabels[$field] ?? $field);
            $column++;
        }

        // Write data
        $row = 2;
        foreach ($data as $item) {
            $column = 'A';
            foreach (array_keys($data[0]) as $field) {
                $textValue = 'Empty';

                if (!empty($item[$field])) {
                    if (is_array($item[$field])) {
                        $textValue = join(', ', $item[$field]);
                    } else {
                        $textValue = $item[$field];
                    }
                }

                $sheet->setCellValue($column . $row, $textValue);

                $column++;
            }

            $row++;
        }

        // Save and output the XLSX file
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $this->entityName . '.xlsx"');
        $writer->save('php://output');
    }
}