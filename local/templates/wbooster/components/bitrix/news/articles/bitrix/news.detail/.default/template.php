<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if (isset($arResult["DETAIL_PICTURE"]["ID"])) {
  $arImgTmp = CFile::ResizeImageGet(
    $arResult["DETAIL_PICTURE"]["ID"],
    array("width" => 1400, "height" => 300),
    BX_RESIZE_IMAGE_EXACT
  );

  $src = $arImgTmp["src"];
} else {
  $src = SITE_TEMPLATE_PATH . '/assets/img/1400x300.png';
}
?>
<div class="articles-detail">

  <div class="articles__info mb-2">
    <div class="articles__info-item">
      <i class="fa-regular fa-calendar"></i>
      <span><?= $arResult["TIMESTAMP_X"] ?></span>
    </div>

    <div class="articles__info-item">
      <i class="fa-regular fa-eye"></i>
      <span>Просмотров: <?= $arResult["SHOW_COUNTER"] ?></span>
    </div>

    <div class="articles__info-item">
      <i class="fa-regular fa-clock"></i>
      <span>Время на прочтение: <span class="time_read"></span></span>
    </div>
  </div>

  <div class="articles-detail__images mb-2">
    <img src="<?= $src ?>" class="img-fluid" alt="<?= $arResult["NAME"] ?>">
  </div>

  <div class="articles-detail__text">
    <div class="articles-detail__introtext">
      <?= $arResult["NAME"] ?>
    </div>

    <div class="articles-detail__detailtext">
      <?= $arResult["DETAIL_TEXT"]; ?>
    </div>
  </div>
</div>
