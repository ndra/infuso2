<? 

exec("/reflex/layout/global");

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