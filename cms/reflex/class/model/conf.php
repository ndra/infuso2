<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель домена
 **/
class Conf extends ActiveRecord\Record {

	/**
	 * Здесь будет лежать объект активного домена
	 **/
	private static $active = null;

	public static function recordTable() {
		return array (
			'name' => 'reflex_conf',
			'fields' => array (
			  array (
			    'name' => 'id',
			    'type' => 'jft7-kef8-ccd6-kg85-iueh',
			  ), array (
			    'name' => 'title',
			    'type' => 'v324-89xr-24nk-0z30-r243',
			    'editable' => '1',
			    'label' => 'Название (рус.)',
			  ), array (
			    'id' => 'bigint',
			    'name' => 'priority',
			    'editable' => 1,
			    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
			  ),
			),
		);
	}

	/**
	 * Возвращает список доманов
	 **/
	public static function all() {
		return \reflex::get(get_class())
			->asc("priority");
	}
	
	/**
	 * Возвращает домен по id
	 **/
	public static function get($id) {
		return service("ar")
			->get(get_class(),$id);
	}
	
}
