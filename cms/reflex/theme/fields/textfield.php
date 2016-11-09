<?

<div class='x8spq9pjwjn' >

    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($field->value());
        
    if($field->param("wide")) {
        $w->style("width", "100%");
    } else {
        $w->style("width", 200);
    }
        
    if($field->editable()) {
        $w->fieldName($field->name());
    } else {
        $w->attr("readonly", true);
    }
        
    $w->exec();
        
</div>