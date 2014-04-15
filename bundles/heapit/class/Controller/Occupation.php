<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Occupation extends Base {
    
    /**
     * Создает контрагента
     **/
    public static function post_addNew($p) {
        $org = \Infuso\Heapit\Model\Org::get($p["orgId"]);
        $occs = $org->occupations()->count();
        $num = $occs + 1;
        $newOccName = "Occupation-".$num;
        $data = array("title"=> $newOccName, "person"=> 1);
        $occItem = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Org", $data);
        $data = array("orgId" => $p["orgId"], "occId"=> $occItem->id());
        $occ = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Occupation", $data);
        $ret = \tmp::get("/heapit/org/content/staff/item", array("occ" => $occ))->getContentForAjax();
        return $ret; 
    }
        
}