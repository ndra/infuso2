<?

<div class='x15OtxtOxFL' >

    foreach($field->options() as $key => $val) {
        <span style='white-space: nowrap;' >
            $id = "x".\infuso\util\util::id();
            $inject = $field->isOptionSelected($key) ? "checked" : "";
            <input id='{$id}' type='checkbox' data:key='{e($key)}' $inject />
            <label for='{$id}' >{$val}</label>
        </span>
        echo " ";
    }
    
    <input type='hidden' name='{e($field->name())}' value='{e($field->value())}' />

</div>