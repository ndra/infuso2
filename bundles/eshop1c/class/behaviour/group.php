<?

namespace Infuso\Eshop1C\Behaviour;
use \Infuso\Core;
use \Infuso\Eshop1C;

/**
 * Поведение для группы тоаров, содержащее все необходимое для интеграции с 1С
 **/ 
class Group extends Core\Behaviour {

    public function addToClass() {
        return "infuso\\eshop\\model\\group";
    }
    
    public function model() {
        return array(
            "fields" => array(
                array(
                    "name" => "importKey",
                    "type" => "string",
                ),
            ),
        );
    }
    
	/**
	 * Обрабатывает XML группы товаров
	 **/
    public function processCatalogXML($groupXML,$xml) {
    
        $group = array(
            "title" => $groupXML->Наименование."",
            "importKey" => $groupXML->Ид."",
        );
        
        $parentXML = end($groupXML->xpath("parent::Группы/parent::Группа"));
        if($parentXML) {
            $parent = $this->processCatalogXML($parentXML,$xml);
            $group["parent"] = $parent->id();
        }
        
        return Eshop1C\Utils::importGroup($group);
        
    }

}
