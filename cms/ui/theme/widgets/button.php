<? 

tmp::jq();
exec("../../shared");

$helper = \Infuso\Template\Helper("<input>");
foreach($widget->attr() as $key => $val) {
    $helper->attr($key, $val);
}
foreach($widget->style() as $key => $val) {
    $helper->style($key, $val);
}
$helper->attr("type", "button");
$helper->addClass("g-button");
$helper->attr("value",rand());
$helper->exec();

/*$button->begin();

    if($icon) {        
        <img class="icon" src='{$icon}' >
    }
    
    if($title && $icon){
        $title = "&nbsp;".$title;
    }
    
    echo $title;

$button->end(); */
