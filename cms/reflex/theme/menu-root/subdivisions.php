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
            </div>
        }
        break;

    case "child":
        mod::msg($nodeId);
        
        //$editor = \Infuso\Cms\Reflex\Editor
        $class = get_class($this);
        $a = $class::inspector()->annotations();
        foreach($a as $fn => $annotations) {
            if($annotations["reflex-child"] == "on") {
                $editor = new $class;
                $collection = $editor->$fn();
                $menu[] = array(
                    "href" => \mod::action(get_class($this),"child",array("id"=>$this->itemID(),"method" => $fn))->url(),
                    "title" => $collection->title(),
                );
            }
        }
        
        break;
        
}