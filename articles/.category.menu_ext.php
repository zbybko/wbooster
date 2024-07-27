<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
    "IS_SEF" => "Y",
    "SEF_BASE_URL" => "#SITE_DIR#/articles/",
    "SECTION_PAGE_URL" => "/category/#CODE#",
    "DETAIL_PAGE_URL" => "#SITE_DIR#/articles/#ELEMENT_ID#/",
    "IBLOCK_TYPE" => "articles",
    "IBLOCK_ID" => "1",
    "DEPTH_LEVEL" => "1",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "3600"
  )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>
