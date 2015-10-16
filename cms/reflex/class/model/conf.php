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

	public static function model() {
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
					'name' => 'name',
					'type' => 'string',
					'editable' => '1',
					'label' => 'Ключ',
				), array (
					'name' => 'priority',
					'label' => "Приоритет",
					'editable' => 0,
					'type' => 'bigint',
				), array (
					'name' => 'type',
					'label' => "Тип",
					'editable' => 1,
					'type' => 'z34g-rtfv-i7fl-zjyv-iome',
				), array (
					'name' => 'value',
					'editable' => 1,
					'label' => "Значение",
					'type' => 'textarea',
				), array (
					"name" => "parent",
					"label" => "Родитель",
					"type" => "link",
                    "class" => self::inspector()->className(),
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
    
    public function children() {
        return self::all()
            ->eq("parent", $this->id());
    }
    
    public function recordParent() {
        return $this->pdata("parent");
    }
	
}
