<? 

/**
 * @param nodeId
 * @param title = "Название ноды",
 * @url = "/reflex/..."
 * @param @expanded = Array(),
 **/
 
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

    <div class='node-body' >
        <span class='expander' ></span>
        <a class='node-title' href='{$url}' >{$title}</a>
    </div>
    <div class='subdivisions' >
        if($nodeExpanded) {
            exec("/reflex/menu-root/subdivisions", array(
                "nodeId" => $nodeId,
            ));
        }                    
    </div>
    
$h->end();