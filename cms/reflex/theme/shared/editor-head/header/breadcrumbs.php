<? 

<div class='p03qzvg1ji' >
    foreach($editor->item()->parents() as $parent) {
        $parent->addBehaviour("\\Infuso\\Cms\\Reflex\\Behaviour\\ActiveRecord");
        <a href='{$parent->editor()->url()}' class='item' >{$parent->title()}</a>
    }
</div>