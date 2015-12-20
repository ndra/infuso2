<? 

exec("/reflex/layout/global");
exec("/ui/shared");
js($this->bundle()->path()."/res/js/sortable.min.js");

$class = "x1arvpu0c38";
if($collection->sortable()) {
    $class.= " sortable";
}

<div class='{$class}' data:collection='{$collection->serialize()}' >

    <div class='items' >
        $n = 0;
        foreach($collection->editors() as $editor) {
            $editor->listItemTemplate()
                ->param("collection", $collection)
                ->exec();
            $n++;
        }
        
        if($n == 0) {
            <div style='padding:5px; opacity: .5; font-style: italic;' >Нет элементов для отображения</div>
        }
        
    </div>
    
</div>