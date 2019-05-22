<?

lib::modjs();

$h = helper("<div>");

foreach($widget->attr() as $key => $val) {
    $h->attr($key, $val);
}

foreach($widget->style() as $key => $val) {
    $h->style($key, $val);
}

$h->addClass("gcr7LERV9A");
$h->attr("data:id", $id);
$h->begin();
    echo $content;
$h->end();