<? 

$h = helper("<span>");

foreach($widget->attr() as $key => $val) {
    $h->attr($key, $val);
}

foreach($widget->style() as $key => $val) {
    $h->style($key, $val);
}

$h->addClass("fr8dqef87w");

$h->begin();

    <input type='hidden' name='{$widget->param("name")}' value='{$widget->param("value")}' />
    <span class='pages' ></span>
    
$h->end();