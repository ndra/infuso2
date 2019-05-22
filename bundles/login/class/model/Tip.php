<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Модель всплывающей подсказки
 **/
class Tip extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'name',
                    'type' => 'textfield',
                    "editable" => 2,
                    "wide" => true,
                    'label' => 'Имя',
                ), array (
                    'name' => 'label',
                    'type' => 'textfield',
                    'editable' => 2,
                    "wide" => true,
                    'label' => 'Название (рус)',
                ), array (
                    'name' => 'text',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Описание',
                ),
            ),
        );
    } 
    
    /**
     * Возвращает все страницы
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("name");
    }
    
    /**
     * Возвращает элемент по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }    

}
