<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
return;

$ajaxUrl = $templateFolder.'/ajax/'.LANGUAGE_ID.'/ajax.php';
?>

<?if(!$arParams['IS_AJAX']):?>
<div class="article">
    <div class="section">
        <div class="brands-block" style="padding: 0; margin-bottom: 15px;">
            <div class="brands-block__wrapper">
                <?/*<div class="brands-block__upper" style="position: absolute; z-index: 1;">
                    <div class="brands-block__title h3 upper"><a class="a_h3" href="<?=SITE_DIR;?>brands/"><?=GetMessage('BRANDS');?></a></div>
                </div>*/?>
                <div class="brands-block__down">
                    <?endif;  // end ajax?>

                        <div class="brands-block__slider long-slider" data-slick="{&quot;slidesToShow&quot;: 5, &quot;slidesToScroll&quot;: 5, &quot;arrows&quot;: true, &quot;dots&quot;: <?=(count($arResult["ITEMS"])>5?"true":"false")?>, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}},{&quot;breakpoint&quot;: 600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2}}]}">

                            <?foreach($arResult["ITEMS"] as $arItem):
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                                
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="brands-block__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                    <div class="brands-block__image" style="height: 6.25rem;">
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

