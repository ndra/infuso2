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

$helper->addClass("g-button");
$helper->exec();