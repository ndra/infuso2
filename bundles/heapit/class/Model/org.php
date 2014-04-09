<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class Org extends \Infuso\ActiveRecord\Record {

	public static function recordTable() {
		return array(
			'name' => 'org',
			'fields' => array(
				array(
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
				), array(
					'name' => 'heapID',
					'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
					'label' => 'ID базы',
				), array(
					'name' => 'deleted',
					'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
					'editable' => '1',
					'label' => 'Помечен на удаление',
				), array(
					'name' => 'created',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
					"default" => "now()",
					'editable' => '1',
					'label' => 'Дата создания',
				), array(
					'name' => 'changed',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
					"default" => "now()",
					'editable' => '1',
					'label' => 'Дата изменения',
				), array(
					'name' => 'opened',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
					'editable' => '1',
					'label' => 'Время открытия',
				), array(
					'name' => 'tags',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Тэги',
				), array(
					'name' => 'phone',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Телефон',
				), array(
					'name' => 'email',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Электропочта',
				), array(
					'name' => 'url',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Сайт',
				), array(
					'name' => 'title',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Название / ФИО',
				), array(
					'name' => 'owner',
					'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
					'editable' => '1',
					'label' => 'Хозяин',
				), array(
					'name' => 'person',
					'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
					'editable' => '1',
					'label' => 'Частное лицо',
				), array(
					'name' => 'icq',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'icq',
				), array(
					'name' => 'skype',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Скайп',
				), array(
					'name' => 'referral',
					'type' => 'link',
					"class" => get_class(),
				) ,
			) ,
		);
	}

	public static function indexTest() {
		return true;
	}
	
	public function index_item($p) {
		$org = self::get($p["id"]);
		$org->registerView();
		$this->app()->tmp()->exec("/heapit/org",array(
		    "org" => $org,
		));
	}

	public function beforeStore(){
	    $this->data("changed", \util::now());
	}

	public function registerView(){
	    $this->data("opened", \util::now());
	}

	public static function all() {
		return \reflex::get(get_class());
	}
	
	public static function get($id) {
		return Core\Mod::service("ar")->get(get_class(),$id);
	}
	
	public function owner() {
		return org_user::all()->eq("id",$this->data("owner"))->one();
	}

	public function occupations() { return org_occupation::all()->eq("orgID",$this->id()); }
	
	public function payments() { return org_payment::all()->eq("orgID",$this->id()); }
	
	public function messages() { return org_chat::all()->eq("parent","org:{$this->id()}"); }

	public function referral() { return self::get($this->data("referral")); }

	public function updateStatus() { return $this->handleTags(); }

}
