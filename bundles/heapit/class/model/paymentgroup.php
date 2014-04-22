<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class PaymentGroup extends \Infuso\ActiveRecord\Record {

    public static function recordTable() {
        return array(
            'name' => 'HeapitPaymentGroup',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array(
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Название',
                ), array(
                    'name' => 'type',
                    'type' => 'select',
                    'editable' => '1',
                    'label' => 'Тип',
                    'values' => array(
						0 => "доход",
						1 => "расход",
					),
                ),
             ),
        );
    }
    
    public static function indexTest() {
        return true;
    }
    
    public function index_item($p) {
        $payment = self::get($p["id"]);
        $this->app()->tmp()->exec("/heapit/payment-group",array(
            "payment" => $payment,
        ));
    }

    public static function all() {
        return \reflex::get(get_class())->asc("title");
    }
    
    public static function get($id) {
        return Core\Mod::service("ar")->get(get_class(),$id);
    }   

}
