<?

js($this->bundle()->path()."/res/js/sortable.min.js");

$h = helper("<div>");
foreach($widget->attr() as $key => $val) {
    $h->attr($key,$val);
}
foreach($widget->style() as $key => $val) {
    $h->style($key, $val);
}
$h->addClass("task-list-rpu80rt4m0");
$h->attr("data:status", $status);
$h->begin();

    if($enbaleToolbar) {
        exec("toolbar");
    }
    
    <div class='ajax-container center' >
    </div>
    
    // Индикатор загрузки
    $loaderSrc = $this->bundle()->path()."/res/img/misc/loader.gif"; 
    <img class="loader" src="{$loaderSrc}" />

$h->end();