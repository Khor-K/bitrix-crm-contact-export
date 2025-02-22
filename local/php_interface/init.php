<?php

CJSCore::Init('jquery3');

if (!isset($_REQUEST['no_init']) && !defined('NO_INIT')) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/includes/ComponentModifier.php')) {
        require $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/includes/ComponentModifier.php';
    }
}