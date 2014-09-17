<?

namespace Infuso\Eshop1C\Behaviour;
use \Infuso\Core;
use \Infuso\Eshop1C;

/**
 * Поведение для товарной позиции, содержащее все необходимое для интеграции с 1С
 **/ 
class Item extends Core\Behaviour {

    public function addToClass() {
        return "infuso\\eshop\\item";
    }

    public function behaviourPriority() {
        return -1;
    }

    /**
     * Дополнительные поля для управления импортом
     **/
    /*public function fields() {
        return array(
            mod_field::get("textfield")->name("importKey")->disable()->label("1С: Внешний ключ")->group("1C"),
            //mod_field::get("datetime")->name("importTime")->disable()->label("1С: Время испорта")->group("1C"),
            //mod_field::get("textfield")->name("importCycle")->disable()->label("1С: Цикл импорта")->group("1C"),
        );
    } */

    /**
     * Метод, обрабатывающий товар из файла import.xml
     * В этом файле приходят описания товаров и групп
     **/
    public function processCatalogXML($towar, $xml) {

        $importKey = $towar->Ид."";
        $data = array(
            "title" => $towar->Наименование."",
            "importKey" => $importKey,
            "article" => $towar->Артикул."",
            "description" => $towar->Описание."",
            "order" => true,
        );
        
        // Загружаем группу
        $groupID = $towar->Группы->Ид."";
        $groupXML = end($xml->xpath("//Классификатор/Группы/descendant::Группа[Ид='$groupID']"));
        
        if($groupXML) {
	        $vgroup = service("ar")->virtual("eshop_group");
	        $group = $vgroup->processCatalogXML($groupXML,$xml);
	        $data["parent"] = $group->id();
		}
        
        $item = Eshop1C\Utils::importItem($data);
    }

    /**
     * Метод, обрабатывающий товар из файла offers.xml
     * В этом файле приходит информация о ценах на товарные позиции
     * (сами товары загружаются в import.xml)
     **/
    public function processOffersXML($offer,$xml) {
        $data = array(
            "price" => end($offer->xpath("descendant::ЦенаЗаЕдиницу"))."",
            "instock" => $offer->Количество."",
            "importKey" => $offer->Ид."",
        );
        Eshop1C\Utils::importItem($data);
    }

}
