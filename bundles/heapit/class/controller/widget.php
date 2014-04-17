<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Widget extends Base {
        
    public function post_orgList($p) {
        $orgs = \Infuso\Heapit\Model\Org::all()->like("title", $p["query"]);
        $ret = array();
        $ret["query"] = $p["query"];
        $suggestions = array();
        $data = array();  
        foreach($orgs as $org){
            $img = "/bundles/heapit/res/img/org/factory.png";
            if($org->data("person")){
                $img = "/bundles/heapit/res/img/org/user.png";    
            }
            $suggestions[] = array("value"=>$org->title(),"key"=>$org->id(), "icon"=>$img);
        }
        $ret["suggestions"] = $suggestions;
        return $ret;
    }
    
    public function post_personalList($p) {
        $orgs = \Infuso\Heapit\Model\Org::all()->like("title", $p["query"])->eq("person", 1);
        $ret = array();
        $ret["query"] = $p["query"];
        $suggestions = array();
        $data = array();  
        foreach($orgs as $org){
            $img = "/bundles/heapit/res/img/org/factory.png";
            if($org->data("person")){
                $img = "/bundles/heapit/res/img/org/user.png";    
            }
            $suggestions[] = array("value"=>$org->title(),"key"=>$org->id(), "icon"=>$img);
        }
        $ret["suggestions"] = $suggestions;
        return $ret;
    }   
        
}
