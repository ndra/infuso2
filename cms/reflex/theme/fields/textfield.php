<? 

tmp::exec("../field-layout" ,array(
    "label" => $field->label(),
    "content" => tmp::get("field",$this->params())->rexec(),
));