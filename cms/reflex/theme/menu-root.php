<? 

<div class='pp7cpa1wpc' >

    $url = action($class,"root",array(
        "method" => $method,
    ));
    
    $nodeId = "root/{$class}/{$method}";
    <div class='node' data:node-id="{$nodeId}" >
    
        <span class='expand' > + </span>
        
        <a class='node-title' href='{$url}' >            
            echo $title;
            echo " (".$collection->collection()->count().")";
        </a>
        
        <div class='subdivisions' >
            if(1) {
                exec("subdivisions", array(
                    "nodeId" => $nodeId,
                ));
            }
        </div>
    
    </div>

</div>