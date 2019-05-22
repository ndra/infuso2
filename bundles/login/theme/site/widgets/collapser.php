<?

lib::modjs();

$h = helper("<div>");

foreach($widget->attr() as $key => $val) {
    $h->attr($key, $val);
}

foreach($widget->style() as $key => $val) {
    $h->style($key, $val);
}

$h->addClass("jYPlW0sJt8");
$h->attr("data:id", $id);
if($keep) {
    $h->attr("data:keep", true);
}
$h->begin();

    echo $content;
    
$h->end();