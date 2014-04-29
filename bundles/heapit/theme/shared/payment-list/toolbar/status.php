<? 

$statuses = \Infuso\Heapit\Model\Payment::enumStatuses();

<span class='year-select-tyt5o23yxj' >    
    foreach($statuses as $val=>$title) {
        $id = \util::id();
        $h = helper("<input checked value='{$val}' type='checkbox' id='{$id}' />");
        $h->exec();
        <label for='{$id}' >{$title}</label>
    }
</span>