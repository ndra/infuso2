<? 

<div class='f0rw8hlkvh' data:editor='{$view->editor()->id()}' >

    $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
        ->value($field->value())        
        ->fieldName($field->name())
        ->style("width", "100%");
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
    
    $w->exec();
    
    if($field->editable()) {
        <div class='toolbar' >
            <span class='bold' ><b>Жирный</b></span> 
            <span class='italic' ><i>Наклонный</i></span> 
            <span class='image' >Изображение</span> 
            <span class='file' >Файл</span>
			<span class='href' >Ссылка</span>			
        </div>
    }

</div>