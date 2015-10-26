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
    
    public static function model() {
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
                    'name' => 'statusPriority',
                    'type' => 'bigint',
                    'label' => 'Приоритет статуса',
                ), array(
                    'name' => 'refusalDescription',
                    'type' => 'select',
                    'values' => self::enumRefusalDescription(),
                    'editable' => '1',
                    'label' => 'Причина отказа',
                ), array(
                    'name' => 'source',
                    'type' => 'select',
                    'values' => self::enumSources(),
                    'editable' => '1',
                    'label' => 'как узнал о нас',
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
                    'name' => 'paymentDate',
                    'type' => 'date',
                    'editable' => '1',
                    'label' => 'Предпологаемая дата оплаты',
                ), array(
                    'name' => 'invoiced',
                    'type' => 'checkbox',
                    'editable' => '1',
                    'label' => 'Выставлен счет',
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
        $this->app()->tm()->exec("/heapit/bargain",array(
            "bargain" => $bargain,
        ));
    }

    public static function all() {
        return \reflex::get(get_class())
            ->desc("created")
            ->addBehaviour("infuso\\heapit\\model\\BargainCollection");
    }
    
    
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public function recordTitle() {
        return $this->org()->title()." / ".$this->data("description");
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

    public function beforeStore() {
        $plist = self::statusPriority();
        $priority = $plist[$this->data("status")];
        $this->data("statusPriority", $priority);
    }

    /**
     * Закрыта ли сделка
     * Закрыта сделки - это те что не в стаьтусе Новая, Переговоры или Отложено
     **/
    public function closed() {
        return !in_array($this->data("status"), array (
            self::STATUS_NEW,
            self::STATUS_INPROCESS,
            self::STATUS_HOLD,
        ));
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

    public static function statusPriority() {
        return array(
            self::STATUS_NEW => 0,
            self::STATUS_INPROCESS => 100,
            self::STATUS_SIGNED => 200,
            self::STATUS_REFUSAL => 200,
            self::STATUS_HOLD => 100,
            self::STATUS_DELETED => 300,
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
    
    public static function enumSources() {
        return array(
            100 => "Нашел в поисковике",
            200 => "Сарафанное радио",
            300 => "Наш старый клиент",
            400 => "Личные знакомые",
            666 => "Кто ж вас не знает?"
        );  
    }
    
}
