<?

<div class='mQ2bn91Yw' >
    foreach($field->items() as $item) {
        $editUrl = $item->plugin("editor")->url();
        <div class='item' data:id='{$item->id()}' data:editUrl='{$editUrl}'>{$item->title()}</div>
    }
</div>