<? 

$editors = \Infuso\CMS\Reflex\Controller\Menu::getSubdividionsByNodeId($nodeId);

foreach($editors as $editor) {    
    $nodeId = "child/".get_class($editor)."/".$editor->itemId();
    exec("/reflex/menu-root/node", array(
        "title" => $editor->title(),
        "url" => $editor->url(),
        "nodeId" => $nodeId,
        "expanded" => $expanded,
    ));
}
