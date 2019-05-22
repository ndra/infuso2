<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Пресет батареи
 **/
class BatteryPreset extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'priority',
                    'type' => 'bigint',
                ), array (
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Название',
                ), array (
                    'name' => 'img',
                    'type' => 'file',
                    'editable' => 1,
                    'label' => 'Фотография',
                ), array (
                    'name' => 'cellId',
                    'type' => 'link',
                    'class' => Cell::inspector()->className(),
                    'editable' => 1,
                    'label' => 'Тип ячеек',
                ), array (
                    'name' => 'serial',
                    'type' => 'bigint',
                    'editable' => 1,
                    'label' => 'Последовательно',
                ), array (
                    'name' => 'parallel',
                    'type' => 'bigint',
                    'editable' => 1,
                    'label' => 'Последовательно',
                ),   
            ),
        );
    }     

    /**
     * Возвращает все страницы из портфолио
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("priority");
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
    
    public function battery() {
        return new \Infuso\Site\Battery($this->data("serial"), $this->data("parallel"), $this->data("cellId"));
    }

}
