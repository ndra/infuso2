<? 

<div class='g-toolbar c-toolbar payment-toolabr-ah3hf8pqdk' >

    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->addClass("quicksearch")
        ->clearButton()
        ->exec();
    
    /*$years = \Infuso\Heapit\Model\Payment::all()->asc("date")->distinct("date", "year");
    
    $last = end($years);
    foreach($years as $year) {
        $id = \util::id();
        $h = helper("<input name='year' value='{$year}' type='checkbox' id='{$id}' />");
        if($year == $last) {
            $h->attr("checked", "checked");
        }
        $h->exec();
        <label for='{$id}' >{$year}</label>
    }*/
    //exec("yearSelect");    
    widget("\\infuso\\cms\\ui\\widgets\\pager")
        ->fieldName("pager")
        ->addClass("pager")
        ->exec();

</div>