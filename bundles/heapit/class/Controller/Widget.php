<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Widget extends Core\Controller {
    
    public static function indexTest() {
        return true;
    }
    
    //индес метод для виджета автокомплита, возвращает json массив данных по организациям
    public function index_orgList($p) {
        $orgs = \Infuso\Heapit\Model\Org::all()->like("title", $p["query"]);
        $ret = array();
        $ret["query"] = $p["query"];
        $suggestions = array();
        $data = array();  
        foreach($orgs as $org){
            $suggestions[] = array("value"=>$org->title(),"data"=>$org->id());
        }
        $ret["suggestions"] = $suggestions;

        echo json_encode($ret);
    }    
        
}