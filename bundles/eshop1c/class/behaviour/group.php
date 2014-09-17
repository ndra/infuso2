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
    
    /*public function fields() {
        return array(
            mod_field::get("textfield")->name("importKey")->disable()->label("1С: Внешний ключ")->group("1C"),
            mod_field::get("datetime")->name("importTime")->disable()->label("1С: Время испорта")->group("1C"),
            mod_field::get("textfield")->name("importCycle")->disable()->label("1С: Цикл импорта")->group("1C"),
            mod_field::get("checkbox")->name("skipImport")->label("1С: Не менять данные товара при импорте")->group("1C"),
            mod_field::get("checkbox")->name("skipImportSys")->disable()->group("1C"),
            mod_field::get("checkbox")->name("skipImportChildren")->label("1С: Не менять содержимое при импорте")->group("1C"),
        );
    }*/
    
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
        
        return eshop_1c_utils::importGroup($group);
        
    }

}
