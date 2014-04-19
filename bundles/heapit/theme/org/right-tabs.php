<? 
    
$tabs = widget("tabs");

$tabs->tab("заметки");
    exec("/heapit/comments", array("parent" => "org:".$org->id()));
$tabs->tab("Платежи");

    exec("payments");
    
$tabs->exec();