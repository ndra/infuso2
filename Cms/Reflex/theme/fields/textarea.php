<? 

<div class='f0rw8hlkvh' >

    if($field->editable()) {
        <textarea name='{$field->name()}' >
            echo $value;
        </textarea>
    } else {
        <textarea disabled>
            echo $value;
        </textarea>
    }

</div>