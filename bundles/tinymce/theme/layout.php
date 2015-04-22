<?

singleJS($this->bundle()->path()."/res/tinymce.min.js");
var_export($params);
<div class='tinyMCE-qPe4r8Zov0h'  data:editor='{$view->editor()->id()}'>

    $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
        ->value($field->value())        
        ->fieldName($field->name())
        ->style("width", "100%");
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
    
    $w->exec();
    
</div>