<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Модель страницы
 **/
class Page extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'priority',
                    'type' => 'integer',
                    'label' => 'Приоритет',
                ), array (
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Название',
                ), array (
                    'name' => 'text',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Описание',
                ), array (
                    'name' => 'href',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Ссылка',
                ), 
            ),
        );
    } 
    
    public function indexTest() {
        return true;
    }

    public function index_item($p) {    
        $page = self::get($p["id"]);
        app()->tm("/site/page")
            ->param("page", $page)
            ->exec();
    }

    /**
     * Возвращает все страницы
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("priority");
    }
    
    /**
     * Возвращает элемент по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }
    
    public function recordURl() {
        return $this->data("href");
    }    

}
