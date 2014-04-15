<? 

list($type,$class,$param) = explode("/",$nodeId);
$collection = new \Infuso\Cms\Reflex\Collection($class,$param);

switch($type) {

    case "root":
        foreach($collection->editors() as $editor) {    
            $nodeId = "child/".get_class($editor)."/".$editor->itemId();
            <div class='node' data:node-id='{$nodeId}' >
                <span class='expand' > + </span>
                <a class='node-title' href='{$editor->url()}' >{$editor->title()}</a>
                <div class='subdivisions' ></div>
            </div>
        }
        break;

    case "child":
       
        $a = $class::inspector()->annotations();
        foreach($a as $fn => $annotations) {
            if($annotations["reflex-child"] == "on") {
                $collection = new \Infuso\Cms\Reflex\Collection($class,$fn,$param);                
                foreach($collection->editors() as $editor) {    
                    $nodeId = "child/".get_class($editor)."/".$editor->itemId();
                    <div class='node' data:node-id='{$nodeId}' >
                        <span class='expand' > + </span>
                        <a class='node-title' href='{$editor->url()}' >{$editor->title()}</a>
                        <div class='subdivisions' ></div>
                    </div>
                }
            }
        }
        
        break;
        
}