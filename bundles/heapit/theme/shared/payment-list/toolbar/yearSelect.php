<? 

$years = \Infuso\Heapit\Model\Payment::all()->asc("date")->distinct("date", "year");
    
$last = end($years);
foreach($years as $year) {
    $id = \util::id();
    $h = helper("<input name='year' value='{$year}' type='checkbox' id='{$id}' />");
    if($year == $last) {
        $h->attr("checked", "checked");
    }
    $h->exec();
    <label for='{$id}' >{$year}</label>
}