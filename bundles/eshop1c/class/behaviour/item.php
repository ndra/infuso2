<?

namespace Infuso\Eshop1C\Behaviour;
use \Infuso\Core;
use \Infuso\Eshop1C;

/**
 * Поведение для товарной позиции, содержащее все необходимое для интеграции с 1С
 **/ 
class Item extends Core\Behaviour {

    public static function addToClass() {
        return "infuso\\eshop\\model\\item";
    }

    public static function behaviourPriority() {
        return -1;
    }

    /**
     * Дополнительные поля для управления импортом
     **/
    public function model() {
        return array(
            "fields" => array(
                array(
                    "name" => "importKey",
                    "type" => "string",
                    "editable" => 2,
                    "label" => "Ключ 1С",
                ), array(
                    "name" => "importCycle",
                    "type" => "string",
                    "editable" => 2,
                    "label" => "Цикл импорта",
                ),
            ),
        );
    }

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
        );
        
        // Загружаем группу
        $groupID = $towar->Группы->Ид."";
        $groupXML = end($xml->xpath("//Классификатор/Группы/descendant::Группа[Ид='$groupID']"));
        
        if($groupXML) {
	        $vgroup = service("ar")->virtual("infuso\\eshop\\model\\group");
	        $group = $vgroup->processCatalogXML($groupXML,$xml);
	        $data["groupId"] = $group->id();
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
