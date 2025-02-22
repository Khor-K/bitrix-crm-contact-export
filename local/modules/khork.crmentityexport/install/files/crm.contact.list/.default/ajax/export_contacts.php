<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Khork\CrmEntityExport\ContactExporter;

Loader::includeModule('khork.crmentityexport');

$request = Application::getInstance()->getContext()->getRequest();
$format = $request->get('format') ?? 'csv';

$obExporter = new ContactExporter();
$obExporter->export($format);