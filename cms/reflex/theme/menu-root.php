<? 

exec("/reflex/layout/global");

$stored = \util::str($stored)->html();
$expandedNodes = $stored->xpath('//div[contains(concat(" ", normalize-space(@class), " "), " expanded ")]');
$expanded = array();
if($expandedNodes) {
    foreach($expandedNodes as $node) {
        $attrs = $node->attributes();
        $expanded[] = $attrs["data:node-id"];
    }
}

<div class='pp7cpa1wpc' >

    $url = action($class,"root",array(
        "method" => $method,
    ));
    
    $nodeId = "root/{$class}/{$method}";
    
    exec("/reflex/menu-root/node", array(
        "title" => (string) $title,
        "url" => (string) $url,
        "nodeId" => $nodeId,
        "expanded" => $expanded,
    ));
    
</div>