<?

namespace Infuso\Cms\Reflex\Model;

use \Infuso\ActiveRecord\Record;
use \mod;

/**
 * Модель вкладки в каталоге
 **/
class RootTab extends Record {

	/**
	 * Описание таблицы
	 **/
	public static function model() {

		return array (
			'name' => 'reflex_editor_rootTab',
			'fields' =>
			array (
				array (
				  'name' => 'id',
				  "type" => "id",
				),
				array (
				  'name' => 'title',
				  'type' => 'textfield',
				),
				array (
				  'name' => 'name',
				  'type' => 'textfield',
				),
				array (
				  'name' => 'priority',
				  'type' => 'bigint',
				),
				array (
				  'name' => 'icon',
				  'type' => 'file',
				),
			),
		);
	}
	
	public static function all() {
	    return service("ar")->collection(get_class())->desc("priority");
	}

	public static function allVisible() {

        $ret = array();
        foreach(self::all() as $tab) {
            if(sizeof($tab->roots())) {
                $ret[] = $tab;
            }
        }
        return $ret;

	}
	
	public static function get($id) {
	    return service("ar")->get(get_class(), $id);
	}

    public function dataWrappers() {
        return array(
            "name" => "mixed/data",
        );
    }
	
	/**
	 * Создает новую вкладку
	 **/
	public static function create($p) {
	    return service("ar")->create(get_class(),$p);
	}

	public function removeAll() {
	    return self::all()->delete();
	}
	
	public function icon() {
	    return $this->pdata("icon");
	}
	
}
