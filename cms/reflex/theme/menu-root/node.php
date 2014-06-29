<? 

if(!$expanded) {
    $expanded = array();
}

$nodeExpanded = in_array($nodeId,$expanded);
$h = helper("<div>");
$h->AddClass("node");
if($nodeExpanded) {
    $h->AddClass("expanded");
}
$h->attr("data:node-id", $nodeId);
if(trim($url,"/") == trim(\mod::url(tmp::param("url"))->path(),"/")) {
    $h->addClass("active");
}
$h->begin();

    $count = \Infuso\CMS\Reflex\Controller\Menu::getSubdividionsByNodeId($nodeId, "count");

    <div class='node-body' >
        if($count) {
            <span class='expander' ></span>
        } else {
            <span class='expander-spacer' ></span>
        }
        <a class='node-title' href='{$url}' >{$title}</a>
        if($count) {
            <span class='count' >{$count}</count>
        }
    </div>
    <div class='subdivisions' >
        if($nodeExpanded) {
            exec("/reflex/menu-root/subdivisions", array(
                "nodeId" => $nodeId,
                "expanded" => $expanded,
            ));
        }                    
    </div>
    
$h->end();