<? 

list($type,$class,$param) = explode("/",$nodeId);
$collection = new \Infuso\Cms\Reflex\Collection($class,$param);

switch($type) {

    // Уровень списка рутов
    case "root":
    
        foreach($collection->editors() as $editor) {    
            $nodeId = "child/".get_class($editor)."/".$editor->itemId();
            exec("/reflex/menu-root/node", array(
                "title" => $editor->title(),
                "url" => $editor->url(),
                "nodeId" => $nodeId,
                "expanded" => $expanded,
            ));
        }
        break;

    // Уровень вложенных редакторов
    case "child":
       
        $a = $class::inspector()->annotations();
        foreach($a as $fn => $annotations) {
            if($annotations["reflex-child"] == "on") {
                $collection = new \Infuso\Cms\Reflex\Collection($class,$fn,$param);                
                foreach($collection->editors() as $editor) {    
                    $nodeId = "child/".get_class($editor)."/".$editor->itemId();
                    exec("/reflex/menu-root/node", array(
                        "title" => $editor->title(),
                        "url" => $editor->url(),
                        "nodeId" => $nodeId,
                        "expanded" => $expanded,
                    ));
                }
            }
        }
        
        break;
        
}