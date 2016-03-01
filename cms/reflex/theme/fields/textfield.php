<?

<div class='x8spq9pjwjn' >

    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($field->value())        
        ->fieldName($field->name());
        
    if($field->param("wide")) {
        $w->style("width", "100%");
    } else {
        $w->style("width", 200);
    }
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
    $w->exec();
        
</div>