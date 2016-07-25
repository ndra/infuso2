<?

$value = $field->value() ? $field->x().",".$field->y() : "";

<div class='xgeK1zTRX' >
    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($value)        
        ->fieldName($field->name());

    $w->style("width", 200);

        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
    $w->exec();
</div>