<? 

<div class='pp7cpa1wpc' >

    $url = new Infuso\Core\Action($class,"root",array(
        "method" => $method,
    ));
    
    <a href='{$url}' >
        echo $title;
        echo " (".$collection->collection()->count().")";
    </a>
    
    <div class='items' >
        foreach($collection->editors() as $editor) {    
            tmp::exec("editor", array(
                "editor" => $editor,
            ));
        }
    </div>

</div>