<? 

<div class='pp7cpa1wpc' >

    $url = new Infuso\Core\Action($class,"root",array(
        "method" => $method,
    ));
    
    <div class='node' data:node-id="root/{$class}/{$method}" >
    
        <span class='expand' > + </span>
        
        <a class='node-title' href='{$url}' >            
            echo $title;
            echo " (".$collection->collection()->count().")";
        </a>
        
        <div class='subdivisions' ></div>
    
    </div>

</div>