<?php

namespace Khork\CrmEntityExport;

use CBitrixComponentTemplate;

class ComponentModifier
{
    private CBitrixComponentTemplate $ob;
    private array $arResult;
    private array $arParams;
    private string $localPath;

    public function __construct(CBitrixComponentTemplate $template, array &$arResult, array &$arParams) {
        $this->ob = $template;
        $this->arResult = &$arResult;
        $this->arParams = &$arParams;

        if ($this->ob->__hasCSS) {
            $this->addCss('style.css');
        }

        if ($this->ob->__hasJS) {
            $this->addJs('script.js');
        }

        $this->addEpilog();

        $this->modifyPath();

        $this->ob->IncludeLangFile();
    }

    private function modifyPath() : void {
        $this->getLocalPath();
        $this->ob->__folder = '/bitrix/components' . $this->ob->getComponent()->getRelativePath() . '/templates/' . $this->ob->__name;
        $this->ob->__file = $this->ob->__folder . '/' . $this->ob->__page . '.php';
        $this->ob->__hasCSS = true;
        $this->ob->__hasJS = true;
    }

    public function addJs(string $jsPath, bool $isExternal = false) : void {
        if (!$isExternal) {
            $jsPath = $this->getLocalPath() . '/' . $jsPath;
        }
        $this->ob->addExternalJs($jsPath);
    }

    public function addCss(string $cssPath, bool $isExternal = false) : void {
        if (!$isExternal) {
            $cssPath = $this->getLocalPath() . '/' . $cssPath;
        }
        $this->ob->addExternalCss($cssPath);
    }

    private function getLocalPath() {
        if (!isset($this->localPath)) {
            $this->localPath = $this->ob->__folder;
        }
        return $this->localPath;
    }

    private function addEpilog() : void {
        $path = $this->getLocalPath() . '/component_epilog.php';
        if (!file_exists($path)) {
            return;
        }

        $this->ob->getComponent()->SetTemplateEpilog([
            'epilogFile' => $path,
            'templateFolder' => $this->getLocalPath(),
        ]);
    }

    // includes bitrix component's result_modifier.php
    public function includeBase() : void
    {
        $this->ob->__IncludeMutatorFile($this->arResult, $this->arParams);
    }
}