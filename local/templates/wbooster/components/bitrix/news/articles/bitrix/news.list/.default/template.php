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
?>

<div class="articles__grid row">
  <? foreach ($arResult["ITEMS"] as $arItem):
    if (isset($arItem["PREVIEW_PICTURE"]["ID"])) {
      $arImgTmp = CFile::ResizeImageGet(
        $arItem["PREVIEW_PICTURE"]["ID"],
        array("width" => 500, "height" => 300),
        BX_RESIZE_IMAGE_PROPORTIONAL
      );

      $src = $arImgTmp["src"];
    } else {
      $src = SITE_TEMPLATE_PATH . '/assets/img/500x300.png';
    }
    ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <articles class="articles col-12 col-md-6 col-lg-4 col-xl-3" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
      <div class="articles__item">
        <div class="articles__top">
          <div class="articles__category">
            <span class="badge text-bg-primary rounded-pill">Primary</span>
            <span class="badge text-bg-primary rounded-pill">Primary</span>
          </div>
          <div class="articles__images">
            <div class="images__thumb">
              <img src="<?= $src ?>" alt="">
            </div>
          </div>
        </div>

        <div class="articles__inner">
          <div class="articles__info">
            <div class="articles__info-item">
              <i class="fa-regular fa-eye"></i>
              <span><?= $arItem["SHOW_COUNTER"] ? $arItem["SHOW_COUNTER"] : '0' ?></span>
            </div>

            <div class="articles__info-item">
              <i class="fa-regular fa-clock"></i>
              <span>10 мин</span>
            </div>

            <div class="articles__info-item">
              <i class="fa-regular fa-star"></i>
              <span>

              </span>
            </div>
          </div>

          <div class="articles__name">
            <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["NAME"] ?></a>
          </div>

          <div class="articles__btn"><a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"
                                        class="btn btn-primary">Подробнее</a></div>
        </div>
      </div>
    </articles>
  <? endforeach; ?>
  <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <br/><?= $arResult["NAV_STRING"] ?>
  <? endif; ?>
</div>
