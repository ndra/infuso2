<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Модель режима разряда
 **/
class Discharge extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'cellId',
                    'type' => 'link',
                    "class" => Cell::inspector()->className(),
                   // 'editable' => 1,
                    'label' => "Ячейка",
                ), array (
                    'name' => 'rate',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Скорость разряда C',
                ), array (
                    'name' => 'voltage',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Напряжение, В',
                ), array (
                    'name' => 'capacity',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Емкость, Ач',
                ), array (
                    'name' => 'cycles-90',
                    'type' => 'decimal',
                    'editable' => 0,
                    'label' => 'Количество циклов до 90% емкости',
                ), array (
                    'name' => 'cycles-80',
                    'type' => 'decimal',
                    'editable' => 0,
                    'label' => 'Количество циклов до 80% емкости',
                ), array (
                    'name' => 'cycles-70',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Количество циклов до 70% емкости',
                ), array (
                    'name' => 'cycles-60',
                    'type' => 'decimal',
                    'editable' => 0,
                    'label' => 'Количество циклов до 60% емкости',
                ), array (
                    'name' => 'comment',
                    'type' => 'textarea',
                    'editable' => 1,
                    'label' => 'Комментарий',
                ),
            ),
        );
    } 
    
    public function recordParent() {
        return $this->pdata("cellId");
    }

    /**
     * Возвращает все страницы из портфолио
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("rate");
    }
    
    /**
     * Возвращает элемент портфолио по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }
    
    public function cell() {
        return $this->pdata("cellId");
    }
    
    public function voltage() {
        return $this->data("voltage");
    }
    
    public function rate() {
        return $this->data("rate");
    }
    
    public function current() {
        return $this->rate() * $this->cell()->nominalCapacity();
    }
    
}
