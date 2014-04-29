<? 

$statuses = \Infuso\Heapit\Model\Payment::enumStatuses();

<span class='year-select'>    
foreach($statuses as $val=>$title) {
    $id = \util::id();
    $h = helper("<input value='{$val}' type='checkbox' id='{$id}' />");
    /*if($year == $last) {
        $h->attr("checked", "checked");
    }*/
    $h->exec();
    <label for='{$id}' >{$title}</label>
}
</span>