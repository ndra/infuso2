<?

if(!tmp::param("fixed-menu")) {
    $inject = " id='raub2v07e-menu' ";
}   

echo "<div style='position:absolute;z-index:10;width:100%;' $inject >";
echo "<div class='raub2v07e-menu' ><div style='padding:20px;' >";


echo "<div class='iizjmykhy6-container' >";

foreach(\infuso\cms\admin\widgets\widget::all() as $widget) {
    if($widget->inMenu()) {
        echo "<div class='iizjmykhy6-widget' style='width:{$widget->width()}px;' >";
        $widget->exec();
        echo "</div>";
    }
}

echo "</div>";

echo "</div></div>";
if(!tmp::param("fixed-menu"))
    echo "<div style='height:30px;background:url(/admin/res/menu-bottom.png)' ></div>";
echo "</div>";