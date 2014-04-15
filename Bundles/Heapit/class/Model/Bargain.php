<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

/**
 * Класс, описывающий сделку
 * эту сущность также называют 'Продажи'
 **/
class Bargain extends \Infuso\ActiveRecord\Record {
    
    const STATUS_NEW  = 0;
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
                    'name' => 'orgId',
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
                    'label' => 'Статус',
                ), array(
                    'name' => 'refusalDescription',
                    'type' => 'select',
                    'values' => self::enumRefusalDescription(),
                    'editable' => '1',
                    'label' => 'Причина отказа',
                ), array(
                    'name' => 'created',
                    'type' => 'date',
                    'default' => 'now()',
                    'label' => 'Создано',
                ), array(
                    'name' => 'callTime',
                    'type' => 'date',
                    'default' => 'now()',
                    'editable' => '1',
                    'label' => 'Когда связаться',
                ), array(
                    'name' => 'userID',
                    'type' => 'link',
                    'class' => '\\Infuso\\User\\Model\\User',
                    'editable' => '1',
                    'label' => 'Ответственный',
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
    
    public static function enumStatuses() {
        return array(
            self::STATUS_NEW => "Новая",
            self::STATUS_INPROCESS => "Переговоры",
            self::STATUS_SIGNED => "Заключен договор",
            self::STATUS_REFUSAL => "Отказ",
        );    
    }
    
    public static function enumRefusalDescription() {
        return array(
            100 => "Клиент мудак",
            200 => "Мы мудаки",
            300 => "Все мудаки",
            400 => "Не срослось",
        );    
    }
    
}
