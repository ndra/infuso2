<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Модель курса валют
 **/
class CurrencyRate extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'rate',
                    'type' => 'decimal',
                    'editable' => '1',
                    'label' => 'Курс',
                ), array (
                    'name' => 'date',
                    'type' => 'date',
                    'editable' => '1',
                    'label' => 'Дата',
                ),
            ),
        );
    } 

    /**
     * Возвращает коллекцию всех курсов
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class())
            ->desc("date");
    }
    
    /**
     * Возвращает элемент по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }
    
    public function recordTitle() {
        return $this->pdata("date")->num().": ".$this->data("rate");
    }

}
