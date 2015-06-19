<?

js($this->bundle()->path()."/res/js/sortable.min.js");

$h = helper("<div>");
foreach($widget->attr() as $key => $val) {
    $h->attr($key,$val);
}
foreach($widget->style() as $key => $val) {
    $h->style($key, $val);
}
$h->addClass("task-list-rpu80rt4m0 c-task-list");
$h->attr("data:status", $status);
$h->begin();

    <div class='search-container' >
        widget("infuso\\cms\\ui\\widgets\\textfield")
            ->style("width", 150)
            ->placeholder("Поиск")
            ->fieldName("query")
            ->clearButton()
            ->exec();
    </div>
    
    <div class='pager' >
        widget("infuso\\cms\\ui\\widgets\\pager")
           ->fieldName("page")
           ->exec();
    </div>
    
    <div class='ajax-container' >
    </div>
    
    // Индикатор загрузки
    $loaderSrc = $this->bundle()->path()."/res/img/misc/loader.gif"; 
    <div class="loader" >Загрузка...</div>

$h->end();