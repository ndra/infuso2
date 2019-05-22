<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Модель для типа химии аккумулятора
 **/
class Chemistry extends \Infuso\ActiveRecord\Record {

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
                ), array (
                    'name' => 'descr',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Описание',
                ),
            ),
        );
    } 
    
    public function indexTest() {
        return true;
    }
    
    public function index_item($p) {
        app()->tm("/site/chemistry")
            ->param("chemistry", self::get($p["id"]))
            ->exec();
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
        return Cell::all()->eq("chemistry", $this->id());
    } 
    
}
