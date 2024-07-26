<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

CJSCore::Init(array("vote_in_list"));
//Let's determine what value to display: rating or average ?
if($arParams["DISPLAY_AS_RATING"] == "vote_avg")
{
	if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
		$DISPLAY_VALUE = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
	else
		$DISPLAY_VALUE = 0;
}
else
	$DISPLAY_VALUE = $arResult["PROPERTIES"]["rating"]["VALUE"];

\Bitrix\Main\Diag\Debug::writeToFile($arResult, 'raiting', '1.txt');
?>
<script>
if(!window.voteScript) window.voteScript =
{
	trace_vote: function(div, flag)
	{
		var my_div;
		var r = div.id.match(/^vote_(\d+)_(\d+)$/);
		for(var i = r[2]; i >= 0; i--)
		{
			my_div = document.getElementById('vote_'+r[1]+'_'+i);
			if(my_div)
			{
				if(flag)
				{
					if(!my_div.saved_class)
						my_div.saved_className = my_div.className;
					if(my_div.className!='star-active star-over')
						my_div.className = 'star-active star-over';
				}
				else
				{
					if(my_div.saved_className && my_div.className != my_div.saved_className)
						my_div.className = my_div.saved_className;
				}
			}
		}
		i = r[2]+1;
		while(my_div = document.getElementById('vote_'+r[1]+'_'+i))
		{
			if(my_div.saved_className && my_div.className != my_div.saved_className)
				my_div.className = my_div.saved_className;
			i++;
		}
	},
	<?
	//16*
	//Интерфейсный JavaScript
	//хороший кандидат на "генерализацию"
	?>
	do_vote: function(div, parent_id, arParams)
	{
		var r = div.id.match(/^vote_(\d+)_(\d+)$/);

		var vote_id = r[1];
		var vote_value = r[2];

		function __handler(data)
		{
			var obContainer = document.getElementById(parent_id);
			if (obContainer)
			{
				//16a Мы предполагаем, что шаблон содержит только один элемент (например div или table)
				var obResult = document.createElement("DIV");
				obResult.innerHTML = data;
				obContainer.parentNode.replaceChild(obResult.firstChild, obContainer);
			}
		}

		BX('wait_' + parent_id).innerHTML = BX.message('JS_CORE_LOADING');
		<?
		//17*
		//Запрос будет отослан напрямую компоненту.
		//18*
		//Добиваем параметры поста выбором пользователя
		?>
		arParams['vote'] = 'Y';
		arParams['vote_id'] = vote_id;
		arParams['rating'] = vote_value;
		<?
		//19*
		//Отправляем запрос
		?>
		BX.ajax.post(
			'/bitrix/components/bitrix/iblock.vote/component.php',
			arParams,
			__handler
		);
		<?
		//20*
		//Продолжение экскурсии в файле component.php (начало)
		?>
	}
}
</script>
<?
//10*
//Обратите внимание на id этого div'а
//Именого его (div'а) содержимое и будет заменяться
//результатом запроса
?>


<span id="wait_vote_<?echo $arResult["ID"]?>"><?= $arResult["PROPERTIES"]["vote_count"]["VALUE"]?> <?= $DISPLAY_VALUE ?></span>
<?
//12*
//Продолжение экскурсии в файле component.php (конец)
?>
