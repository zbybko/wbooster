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

$currentDir = $APPLICATION->GetCurDir();

?>

<div class="articles__grid row">
  <? foreach ($arResult["ITEMS"] as $index => $arItem):
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
    \Bitrix\Main\Diag\Debug::writeToFile($currentDir, '', '1.txt');
    $arParentSection = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"])->Fetch();
    if ($currentDir !== '/articles/') {
      // Если пользователь находится в разделе
      $link = $arParentSection["CODE"];
    } else {
      // Если пользователь находится в корне /articles/
      $link = $arParentSection["SECTION_PAGE_URL"] . $arParentSection["CODE"];
    }

    ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <articles class="articles col-12 col-md-6 col-lg-4 col-xl-3" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
      <div class="articles__item">
        <div class="articles__top">
          <a href="<?= $link ?>" class="articles__category">
            <span
              class="badge text-bg-primary rounded-pill"><?= $arParentSection["NAME"] ?>
            </span>
          </a>
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
              <span data-timeread="<?= $index ?>"></span>
            </div>

            <div class="articles__info-item">
              <i class="fa-regular fa-star"></i>
              <span>
                <?
                $APPLICATION->IncludeComponent(
                  "bitrix:iblock.vote",
                  "vote_in_list",
                  [
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ELEMENT_ID" => $arItem["ID"],
                    "MAX_VOTE" => $arParams["MAX_VOTE"],
                    "VOTE_NAMES" => $arParams["VOTE_NAMES"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                  ],
                  $component,
                  ['HIDE_ICONS' => 'Y']
                ); ?>
              </span>
            </div>
          </div>

          <div class="articles__name">
            <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["NAME"] ?></a>
          </div>

          <div class="articles__btn">
            <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"
               class="btn btn-primary" data-btn="to_detail">Подробнее
            </a>
          </div>
        </div>
      </div>
    </articles>
  <? endforeach; ?>
  <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <br/><?= $arResult["NAV_STRING"] ?>
  <? endif; ?>
</div>

<script>
  $(document).ready(function () {
    const btnToDetail = $('[data-btn="to_detail"]');
    const timeReadBlocks = $('[data-timeread]');

    console.log(timeReadBlocks);

    if (btnToDetail.length === timeReadBlocks.length) {
      const arrLenght = btnToDetail.length;

      for (let i = 0; i < arrLenght; i++) {
        const pathToDetail = $(btnToDetail[i]).attr('href');
        const currentInnerBlock = timeReadBlocks[i];

        $.ajax({
          url: pathToDetail,
          method: 'GET',
          success: function (data) {

            // Создаем временный элемент для хранения данных
            const tempElement = document.createElement('div');
            tempElement.innerHTML = data;

            // Находим нужные элементы в полученном HTML
            const detailElement = tempElement.querySelector('.articles-detail');
            console.log(currentInnerBlock);
            // Применяем функцию readtime к найденным элементам
            setTimeout(() => {
              $(detailElement).readtime({
                wpm: 160,
                format: '#',
                images: 12,
                readInnerBlock: currentInnerBlock
              });
            }, 200);

          },
          error: function (xhr, status, error) {
            console.error('Ошибка AJAX-запроса:', error);
          }
        });
      }
    } else {
      console.log("Неодинаковое количество элементов")
    }
  });
</script>
