<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult))
    return "";
$countBr = count($arResult);
$strReturn = '<div class="bread"><div class="bread__inner"><div class="bread__list">';


$i=1;
for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
    if($index > 0)
        $strReturn .= '';

    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $title = strip_tags(htmlspecialchars_decode($title));
    if($arResult[$index]["LINK"] <> "" && $countBr != $i){
        $strReturn .= '<a class="bread__item" href="'.$arResult[$index]["LINK"].'">'.$title.'</a>';
    }else{
        $strReturn .= ' <p class="bread__item">' .$title.'</p>';
    }
    $i++;
}

$strReturn .= '</div></div></div>';
return $strReturn;
?>
