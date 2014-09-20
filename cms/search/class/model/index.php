<?

namespace Infuso\Cms\Search\Model;
use \Infuso\Core;

/**
 * Модель индекса поиска
 **/
class Index extends \Infuso\ActiveRecord\Record {

	public static function model() {
	
		return array (
			'name' => get_class(),
			'fields' => array (
				array (
					'name' => 'id',
					'type' => 'id',
				), array (
					'name' => 'key',
					'type' => 'textfield',
                    'length' => 80,
				), array (
					'name' => 'content',
					'type' => 'textarea',
				), array (
					'name' => 'priority',
					'type' => 'bigint',
				), array (
					'name' => 'datetime',
					'type' => 'datetime',
				),  array (
					'name' => 'cycle',
					'type' => 'string',
                    'length' => 40,
				),
			),
		);
	}
    
    /**
     * Возвращает коллекцию задач
     **/
    public static function all() {
        return \reflex::get(get_class());
    }

    /**
     * Возвращает объект по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public function item() {
        list($class,$id) = explode(":", $this->data("key"));
        return service("ar")->get($class,$id);
    }

}
