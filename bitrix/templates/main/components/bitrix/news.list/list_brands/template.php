<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
return;

$ajaxUrl = $templateFolder.'/ajax/'.LANGUAGE_ID.'/ajax.php';
?>

<?if(!$arParams['IS_AJAX']):?>
<div class="article">
    <div class="section">
        <div class="brands-block">
            <div class="brands-block__wrapper">
                <div class="brands-block__upper">
                    <div class="brands-block__title h3 upper"><?=GetMessage("TITLE_BLOCK_BRANDS_LIST")?></div>
                    <div class="dropdown-list">
                        <div class="dropdown-list__wrapper">
                            <div class="dropdown-list__image">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                </svg>
                            </div>
                            <div class="dropdown-list__main">
                                <div class="dropdown-list__item dropdown-list__item--main"><?=GetMessage("BLOCK_BRANDS_LIST_BTN_ALL")?></div>
                            </div>
                            <div class="dropdown-list__items-wrapper">
                                <div class="dropdown-list__items-scroll">
                                    <?foreach($arResult["LIST_COUNTRY"] as $arCountry):?>
                                        <?if($arCountry["ITEMS"]):?>
                                        <div class="click-ajax-filter dropdown-list__item" data-country="<?=$arCountry["NAME"]?>">
                                            <?=$arCountry["NAME"]?>
                                        </div>
                                        <?endif;?>
                                    <?endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="brands-block__down">
                    <?endif;  // end ajax?>

                        <div class="brands-block__slider long-slider" data-slick="{&quot;slidesToShow&quot;: 5, &quot;slidesToScroll&quot;: 5, &quot;arrows&quot;: false, &quot;dots&quot;: <?=(count($arResult["ITEMS"])>5?"true":"false")?>, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}},{&quot;breakpoint&quot;: 600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2}}]}">

                            <?foreach($arResult["ITEMS"] as $arItem):
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                                
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="brands-block__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                    <div class="brands-block__image">
                                        <img src="<?=$arItem["RESIZE_IMG"]["src"]?>" alt="<?=$arItem["NAME"]?>">
                                    </div>
                                </a>
                                
                            <?endforeach;?>
                        </div>
                    <?if(!$arParams['IS_AJAX']):?>
            </div>
        </div>
    </div>
</div>
<script>
        function filterBrandsList(self){
            var num = self.data('country');

            $.ajax({
                datatype: "html",
                url: '<?=$ajaxUrl?>',
                data: "ID_COUNTRY="+num + "&IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>",

                success: function(data){

                    $('.dropdown-list__item--main').click();
                    $('.dropdown-list__item--main').html(num);
                    $('.brands-block__down').html(data);
                    $('.brands-block__slider').slick();
                }
            });
        }
        function setHandlers(){

            var pic = $('.click-ajax-filter');
            pic.on('click', function(){
                filterBrandsList($(this));
                return false;
            });
        }
        $(document).ready(function(){
            setHandlers();
        });
    </script>
<?endif;  // end ajax?>

