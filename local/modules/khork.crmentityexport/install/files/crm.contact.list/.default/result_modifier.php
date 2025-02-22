<?php
/*
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Loader;
use Khork\CrmEntityExport\ComponentModifier;

Loader::includeModule('khork.crmentityexport');
CJSCore::Init('jquery3');

$obModifier = new ComponentModifier($this, $arResult, $arParams);
