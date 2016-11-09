<? 

<div class='f0rw8hlkvh' data:editor='{$view->editor()->id()}' >

    if($field->editable()) {
        $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
            ->value($field->value())
            ->style("width", "100%")
            ->fieldName($field->name())
            ->exec();
    } else {
        <pre>
            echo e($field->value());
        </pre>
    }
    
    
    
    if($field->editable() && $html) {
        <div class='toolbar' >
            <span class='bold' ><b>Жирный</b></span> 
            <span class='italic' ><i>Наклонный</i></span> 
            <span class='image' >Изображение</span> 
            <span class='file' >Файл</span>
			<span class='href' >Ссылка</span>
			<span class='tipograf' >Типографить</span>			
        </div>
    }

</div>