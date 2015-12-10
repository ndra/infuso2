<?

$item = $editor->item();

// Глубина в дереве
if(!$level) {
    $level = 0;
}

<div class='ffm94FCxk2 list-item' data:id='{$editor->id()}' >
	
	exec("item", array(
        "editor" => $editor,
	));
	
	if(array_key_exists("parent", $collection->collection()->eqs())) {
        foreach($item->children() as $sub) {
    	    exec("item", array(
                "editor" => $sub->plugin("editor"),
                "level" => $level + 1
    	    ));
    	}
	}
                    
</div>