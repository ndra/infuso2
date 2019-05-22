<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Модель производителя
 **/
class Vendor extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Название',
                ),
            ),
        );
    }     

    /**
     * Возвращает все страницы из портфолио
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class());
    }
    
    /**
     * Возвращает элемент портфолио по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }
    
    public function cells() {
        return Cell::all()->eq("vendor", $this->id());
    }
    
}
