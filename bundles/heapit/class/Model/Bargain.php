<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

/**
 * Класс, описывающий сделку
 * эту сущность также называют 'Продажи'
 **/
class Bargain extends \Infuso\ActiveRecord\Record {

	public static function recordTable() {
		return array(
			'name' => 'heapitBargain',
			'fields' => array(
				array(
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
				), array(
					'name' => 'title',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Название сделки',
				),
			) ,
		);
	}

	public static function indexTest() {
		return true;
	}
	
	public function index_item($p) {
		$bargain = self::get($p["id"]);
		$this->app()->tmp()->exec("/heapit/bargain",array(
		    "bargain" => $bargain,
		));
	}

	public static function all() {
		return \reflex::get(get_class());
	}
	
	public static function get($id) {
		return Core\Mod::service("ar")->get(get_class(),$id);
	}
	
}
