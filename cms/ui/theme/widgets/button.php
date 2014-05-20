<? 

tmp::jq();
exec("../../shared");

$helper = \Infuso\Template\Helper("<input>");

$helper->attr("type", "button");

if($text = $widget->param("text")) {
    $helper->attr("value", $text);
}

foreach($widget->attr() as $key => $val) {
    $helper->attr($key, $val);
}

foreach($widget->style() as $key => $val) {
    $helper->style($key, $val);
}

if($icon = $widget->param("icon")) {
    $helper->style("background-image", "url({$icon})");
    
    if(!$text) {
        $helper->addClass("icon-only");
    } else {
        $helper->addClass("icon-and-text");
    }
}

if($widget->param("air")) {
    $helper->addClass("air");
}

$helper->addClass("g-button");
$helper->exec();