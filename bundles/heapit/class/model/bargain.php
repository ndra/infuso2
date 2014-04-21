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
    const STATUS_HOLD = 500;
    const STATUS_DELETED = 1000;
    
    public static function recordTable() {
        return array(
            'name' => 'heapitBargain',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
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
                    'name' => 'lastComment',
                    'type' => 'datetime',
                    'default' => 'now()',
                    'editable' => '1',
                    'label' => 'Последний комментарий',
                ), array(
                    'name' => 'userId',
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
        return \reflex::get(get_class())
            ->desc("created")
            ->addBehaviour("infuso\\heapit\\model\\BargainCollection");
    }
    
    
    public static function get($id) {
        return Core\Mod::service("ar")->get(get_class(),$id);
    }
    
    public function org() {
        return $this->pdata("orgId");
    }
    
    public function handleComment() {
        $this->data("lastComment", $this->comments()->max("datetime"));
    }
    
    public function responsibleUser() {
        return $this->pdata("userId");
    }
    
    public function comments() {
        return Comment::all()->eq("parent","bargain:".$this->id());
    }
    
    public static function enumStatuses() {
        return array(
            self::STATUS_NEW => "Новая",
            self::STATUS_INPROCESS => "Переговоры",
            self::STATUS_SIGNED => "Заключен договор",
            self::STATUS_REFUSAL => "Отказ",
            self::STATUS_HOLD => "Отложен",
            self::STATUS_DELETED => "Удалено",
        );    
    }
    
    public static function enumRefusalDescription() {
        return array(
			100 => "Дорого",
			200 => "Выбрали предыдущего разработчика",
			300 => "Клиент пропал",
			400 => "Не увидели того что хотели",
			500 => "Хотят битрикс / другую ЦМС",
			600 => "Хотят гарантию за результат",
			700 => "Отложили задачу",
			666 => "Мы сами отказались"
        );    
    }
    
}
