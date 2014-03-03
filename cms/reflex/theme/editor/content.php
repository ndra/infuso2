<? 

$item = $editor->item();

tmp::exec("header");

<div class='svfo38b38d' >
    foreach($item->fields() as $field) {
        <div>
            tmp::exec("/reflex/fields/textfield",array(
                "field" => $field,
            ));
        </div>
    }
   
</div>