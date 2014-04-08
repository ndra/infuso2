<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

/**
 * Класс, описывающий сделку
 * эту сущность также называют 'Продажи'
 **/
class Bargain extends \Infuso\ActiveRecord\Record {
    
    const STATUS_NEW  = 100;
    const STATUS_INPROCESS = 200;
    const STATUS_SIGNED = 300;
    const STATUS_REFUSAL = 400;
    
    public static function recordTable() {
        return array(
            'name' => 'heapitBargain',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array(
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Название сделки',
                ), array(
                    'name' => 'orgID',
                    'type' => 'link',
                    'editable' => '1',
                    'class' => 'Infuso\\Heapit\\Model\\Org',
                    'label' => 'Организация',
                ), array(
                    'name' => 'description',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Описание',
                ), array(
                    'name' => 'amount',
                    'type' => 'currency',
                    'editable' => '1',
                    'label' => 'Сумма',
                ), array(
                    'name' => 'status',
                    'type' => 'select',
                    'values' => self::enumStatuses(),
                    'editable' => '1',
                    'label' => 'Сумма',
                ), array(
                    'name' => 'refusalDescription',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Причина отказа',
                ),
            ) ,
        );
    }

    public static function indexTest() {
        return true;
    }
    
    public function index_item($p) {
        $bargain = self::get($p["id"]);
        $this->app()->tmp()->exec("/heapit/bargain",array(
            "bargain" => $bargain,
        ));
    }

    public static function all() {
        return \reflex::get(get_class());
    }
    
    
    public static function get($id) {
        return Core\Mod::service("ar")->get(get_class(),$id);
    }
    
    public function enumStatus() {
        return array(
            self::STATUS_NEW => "Новая",
            self::STATUS_INPROCESS => "Переговоры",
            self::STATUS_SIGNED => "Заключен договор",
            self::STATUS_REFUSAL => "Отказ",
        );    
    }
    
}
