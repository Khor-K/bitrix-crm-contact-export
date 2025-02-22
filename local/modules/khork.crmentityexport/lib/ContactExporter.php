<?php

namespace Khork\CrmEntityExport;

use Bitrix\Crm\ContactTable;
use Bitrix\Main\Loader;
use Bitrix\Main\UserFieldTable;

class ContactExporter extends AbstractExporter
{
    public function __construct()
    {
        Loader::includeModule('crm');
        parent::__construct('contacts');
    }

    protected function fetchData(array $select, array $filter): array
    {
        $baseFilter = [
            'EXPORT' => true,
        ];

        return ContactTable::getList([
            'select' => $select,
            'filter' => array_merge($baseFilter, $filter),
        ])->fetchAll();
    }

    protected function fetchFieldLabels(): array
    {
        // Fetch standard field titles
        $standardFields = ContactTable::getEntity()->getFields();
        $standardFieldLabels = [];
        foreach ($standardFields as $field) {
            $standardFieldLabels[$field->getName()] = $field->getTitle();
        }

        // Fetch custom field titles
        $userFields = UserFieldTable::getList([
            'filter' => [
                'ENTITY_ID' => 'CRM_CONTACT'
            ],
            'select' => [
                'FIELD_NAME',
                'TITLE' => 'LABELS.EDIT_FORM_LABEL',
            ],
            'runtime' => [
                UserFieldTable::getLabelsReference()
            ]
        ])->fetchAll();

        $customFieldLabels = [];
        foreach ($userFields as $userField) {
            $customFieldLabels[$userField['FIELD_NAME']] = $userField['TITLE'];
        }

        return array_merge($standardFieldLabels, $customFieldLabels);
    }
}