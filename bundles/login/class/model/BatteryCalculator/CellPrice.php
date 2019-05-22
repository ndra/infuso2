<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Модель цены ячейки
 **/
class CellPrice extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'sizeId',
                    'type' => 'link',
                    'label' => 'Типоразмер',
                    //'editable' => 1,
                    'class' => Size::inspector()->className(),
                ),  array (
                    'name' => 'quantity',
                    'type' => 'bigint',
                    'editable' => 1,
                    'label' => 'Количество',
                ), array (
                    'name' => 'rate',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Коэффициент оптовости (0 &mdash; розница, 1 &mdash; опт)',
                ),
            ),
        );
    } 
    
    /**
     * Возвращает все
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("quantity");
    }
    
    /**
     * Возвращает элемент
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }    
    
    public function recordTitle() {
        return $this->data("quantity")." &mdash; ".$this->data("rate");
    }
    
    public function recordParent() {
        return $this->pdata("sizeId");
    }

}
