<? 

<div class='p03qzvg1ji' >
    foreach($editor->item()->parents() as $parent) {
        <a href='{$parent->plugin("editor")->url()}' class='item' >{$parent->title()}</a>
    }
</div>
