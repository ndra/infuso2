<? 

<form class='bv3vjfvd5n' >
    
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
    
    <span style='margin-right: 40px' ></span>

    $id = \util::id();
    <input name='income' checked type='checkbox' id='{$id}' />
    <label for='{$id}' >Доход</label>    

    $id = \util::id();
    <input name='expenditure' type='checkbox' id='{$id}' />
    <label for='{$id}' >Расход</label>
    
</form>