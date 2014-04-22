<? 
    
$tabs = widget("tabs");

$tabs->tab("заметки");

    exec("/heapit/comments", array("parent" => "org:".$org->id()));
    
$tabs->tab("Платежи");

    exec("/heapit/shared/payment-list", array("orgId" => $org->id()));
    
$tabs->exec();