<? 

$w = new \Infuso\Cms\UI\Widgets\Autocomplete();
$w->fieldName("occId");
$w->cmd("/infuso/heapit/controller/widget/personalList");
$w->exec();