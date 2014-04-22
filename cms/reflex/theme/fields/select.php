<? 

<div class='ldz2q231kh' >

    <select name='{e($field->name())}' >
        foreach($field->options() as $key => $val) {
        
            if($key == $field->value()) {
                <option selected value='{e($key)}' >{e($val)}</option>
            } else {
                <option value='{e($key)}' >{e($val)}</option>
            }
        }
    </select>

</div>