<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class Payment extends \Infuso\ActiveRecord\Record {

    public static function recordTable() {
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
                    'type' => 'currency',
                    'editable' => '1',
                    'label' => 'Приход',
                ), array(
                    'name' => 'expenditure',
                    'type' => 'currency',
                    'editable' => '1',
                    'label' => 'Приход',
                ), array(
                    'name' => 'date',
                    'type' => 'date',
                    'editable' => '1',
                    'label' => 'Дата платежа',
                    'default' => 'now()',
                ),
             ),
        );
    }
    
    public static function indexTest() {
        return true;
    }
    
    public function index_item($p) {
        $payment = self::get($p["id"]);
        $this->app()->tmp()->exec("/heapit/payment",array(
            "payment" => $payment,
        ));
    }

    public function org() {
        return $this->pdata("orgId");
    }
    
    public static function all() {
        return \reflex::get(get_class());
    }
    
    public static function get($id) {
        return Core\Mod::service("ar")->get(get_class(),$id);
    }   

}
