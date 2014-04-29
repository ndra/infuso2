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

    public function reportColor() {
        $colors = array(
            "#3366CC",
            "#DC3912",
            "#FF9900",
            "#109618",
            "#990099",
            "#3B3EAC",
            "#0099C6",
            "#DD4477",
            "#66AA00",
            "#B82E2E",
            "#316395",
            "#994499",
            "#22AA99",
            "#AAAA11",
            "#6633CC",
            "#E67300",
            "#8B0707",
            "#329262",
            "#5574A6",
            "#3B3EAC",
        );
        return $colors[$this->id() % sizeof($colors)];
    }

}
