<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class Payment extends \Infuso\ActiveRecord\Record {

    //планируется, высталвен счет,  оплачено
	const STATUS_PLAN = 50;
    const STATUS_PUSHED = 100;
    const STATUS_PAID = 200;
    const STATUS_DELETED = 300;
    
    public static function model() {
        return array(
            'name' => 'heapitPayment',
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
                    'name' => 'income',
                    'type' => 'cost',
                    'editable' => '1',
                    'label' => 'Приход',
                ), array(
                    'name' => 'expenditure',
                    'type' => 'cost',
                    'editable' => '1',
                    'label' => 'Приход',
                ), array(
                    'name' => 'date',
                    'type' => 'date',
                    'editable' => '1',
                    'label' => 'Дата платежа',
                    'default' => 'now()',
                ), array(
                    'name' => 'status',
                    'type' => 'select',
                    'values' => self::enumStatuses(),
                    'editable' => '1',
                    'label' => 'Причина отказа',
                    'default' => 200
                ), array(
                    'name' => 'group',
                    'type' => 'link',
                    'editable' => '1',
                    'label' => 'Статья доходов / расходов',
                    'class' => PaymentGroup::inspector()->className(),
                ), array(
                    'name' => 'userId',
                    'type' => 'link',
                    'editable' => '1',
                    'label' => 'Ответственный',
                    'class' => \user::inspector()->className(),
                ),
             ),
        );
    }
    
    public static function indexTest() {
        return true;
    }
    
    public function index_item($p) {
        $payment = self::get($p["id"]);
        $this->app()->tm()->exec("/heapit/payment",array(
            "payment" => $payment,
        ));
    }

    public function org() {
        return $this->pdata("orgId");
    }
    
    public static function all() {
        return \reflex::get(get_class())->desc("date")->addBehaviour("infuso\\heapit\\model\\PaymentCollection");
    }
    
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }   
    
    public function group() {
        return $this->pdata("group");
    }
    
    public function enumStatuses() {
        return array(
            self::STATUS_PLAN => "Планируется",
            self::STATUS_PUSHED => "Выставлен счет",
            self::STATUS_PAID => "Оплачено",
            self::STATUS_DELETED => "Отменено",
        );    
    }
}
