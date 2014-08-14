<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель для индексации групп и товаров
 **/
class Index extends \Infuso\ActiveRecord\Record {

	public static function recordTable() {
        return array (
      		'name' => get_class($this),
      		'fields' => array (
			    array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
				), array (
					'name' => 'type',
					'type' => 'bigint',
					'label' => 'Тип (товар, группа и т.п.)',
				), array (
					'name' => 'itemId',
					'type' => 'bigint',
					'label' => 'id группы или товара',
				),   array (
					'name' => 'status',
					'type' => 'bigint',
					'label' => 'Статус',
				),
            ),
        );
    }

	/**
	 * Возвращает коллекцию всех групп
	 **/
	public static function all() {
	    return service("ar")
            ->collection(get_class())
            ->asc("id");
	}

	/**
	 * Возвращает группу по id
	 **/
	public static function get($id) {
	    return service("ar")->get(get_class(),$id);
	}
	
}
