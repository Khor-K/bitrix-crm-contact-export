<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class khork_crmentityexport extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
        
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        
        $this->MODULE_ID = 'khork.crmentityexport';
        $this->MODULE_NAME = Loc::getMessage('KHORK_CRMENTITYEXPORT_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('KHORK_CRMENTITYEXPORT_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('KHORK_CRMENTITYEXPORT_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = '';
    }

    public function doInstall()
    {
        $this->installFiles();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function doUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $this->uninstallFiles();
    }

    public function installFiles()
    {
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/files/crm.contact.list",
            $_SERVER["DOCUMENT_ROOT"]. '/local/templates/.default/components/bitrix/crm.contact.list', true, true
        );

        return true;
    }

    public function uninstallFiles()
    {
        deleteDirFilesEx('/local/templates/.default/components/bitrix/crm.contact.list');
    }
}
