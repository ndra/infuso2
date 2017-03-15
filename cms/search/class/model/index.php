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
                    "editable" => 2,
                    'length' => 80,
                    "label" => "Ключ",
				), array (
					'name' => 'content',
					'type' => 'textarea',
                    "editable" => 2,
                    "label" => "Контент",
				), array (
					'name' => 'priority',
					'type' => 'bigint',
                    "editable" => 2,
                    "label" => "Приоритет",
				), array (
					'name' => 'datetime',
					'type' => 'datetime',
                    "editable" => 2,
                    "label" => "Дата и время",
				),  array (
					'name' => 'cycle',
					'type' => 'string',
                    'length' => 40,
                    "editable" => 2,
                    "label" => "Цикл",
				),
			),
		);
	}
    
    /**
     * Возвращает коллекцию задач
     **/
    public static function all() {
        return service("ar")
			->collection(get_class())
			->asc("priority");
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
    
    public function snippet() {
    
        $template = "/search/snippet";
    
        $params = $this->item()->searchContent();
        if(is_array($params) && array_key_exists("snippet", $params)) {
            $template = $params["snippet"];
        }
    
        return app()->tm($template)
            ->param("index", $this)
            ->param("item", $this->item());
    }

}
