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
					'editable' => '1',
					'label' => 'Дата создания',
				), array(
					'name' => 'changed',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
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
					'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
				) ,
			) ,
		);
	}

	public static function indexTest() {
		return true;
	}
	
	public function index_item($p) {
		$org = self::get($p["id"]);
		$this->app()->tmp()->exec("/heapit/org",array(
		    "org" => $org,
		));
	}

	public function beforeCreate() {
	    $this->data("created",util::now());
	    $this->data("changed",util::now());
	}
	
	public function beforeStore(){
	    $this->data("changed",util::now());
	    $this->handleTags();
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
	public function bills() { return org_bill::all()->eq("orgID",$this->id()); }
	public function messages() { return org_chat::all()->eq("parent","org:{$this->id()}"); }

	public function reflex_url() { return "/org/#org:{$this->id()}/"; }

	public function referral() { return self::get($this->data("referral")); }

	public function updateStatus() { return $this->handleTags(); }

	// -------------------------------------------------------------

	public static function postTest() { return true; }
	public static function post_search($p) {

	    $items = user::active()->visibleHeaps()->eq("id",$p["heapID"])->one()->orgs();
	    $items->page($p["page"]);

	    // Учитываем поиск по имени
	    if($search = trim($p["search"])) $items->like("title","$search");

	    // Учитываем тэг
	    if($tag=$p["tag"]) $items->like("tags",",$tag,");

	    $order = $p["order"];
	    if(!$order) $order = "opened";
	    switch($order) {
	    	case "balance":
	    		$items->asc("balance");
	    		$items->neq("balance",0); // При сортировке по балансу не учитываем объекты с нулевым балансом
	    		break;
	    	case "deleted":
	    		$items->desc("deleted");
	    		break;
			default:
			    $items->eq("deleted",0);
			    $items->desc($order);
			    break;
	    }

	    mod_cmd::meta("pages",$items->pages());
	    $ret = array();
	    foreach($items as $item)
	        $ret[] = $item->listData();

	    $status = "";
	    $status.= "Карточек в базе: ".$items->count();
	    mod_cmd::meta("status",$status);
	    mod_cmd::meta("cols",array(
	        "icon" => array("type"=>"image"),
	        "title" => array("title"=>"ФИО / Название","width"=>300),
	        "phone" => array("title"=>"Телефон","width"=>140),
	        "email" => array("title"=>"E-mail","width"=>220),
	        "balance" => array("title"=>"Баланс","width"=>70),
	      //  "heap" => array("title"=>"База","width"=>220),
		));
	    return $ret;
	}

	public function listData() {
		if(!$this->security(100))
			return array(
				"id" => $this->id(),
				"title" => "<b>{$this->id()}. Просмотр недоступен</b>",
	        );

		$txt = "";
		$oo = array();
		foreach(org_occupation::all()->eq("personID",$this->id()) as $o)
		    $oo[] = $o->org()->title();
		$txt = implode(",",$oo);
		if($txt) $txt = "<div style='color:gray;font-size:10px;'>$txt</div>";

		$title = $this->title();
		if($this->data("deleted")) $title = "<s>$title</s>";

		return array(
		    "id" => $this->id(),
		    "icon" => $this->data("person") ? "user" : "building",
		    "title" => $title,
		    "phone" => $this->data("phone"),
		    "email" => "<a href='mailto:{$this->data(email)}'>{$this->data(email)}</a>",
		   // "heap" => $this->heap()->title(),
		    "balance" => "<a target='_new' href='/org/stat/balance/-/{$this->id()}/'>".$this->data("balance")."</a>",
	     	"url" => $this->url(),
	     	"text" => $txt,
		);

	}

	public static function post_getData($p) {
	    $org = self::get($p["orgID"]);
	    if(!$org->security(100))
	        return false;

	    $org->data("opened",util::now());
	    $data = $org->data();
	    $data["heapID"] = "{$org->heap()->id()}.{$org->heap()->title()}";
	    if($org->referral()->exists())
	    	$data["referral"] = "{$org->referral()->id()}.{$org->referral()->title()}";
	    $data["tags"] = trim($data["tags"],",");
	    return $data;
	}

	// Вносит изменения в карточку
	public static function post_save($p) {

		if(!$p["data"]["title"]) {
		    log::msg("Название не указано",1);
		    return false;
		}

		if($p["orgID"]=="new") {
		    $heap = org_heap::get($p["data"]["heapID"]);

		    if(!$heap->exists()) {
		        log::msg("База не выбрана",1);
		        return;
		    }

		    if(!$heap->security(200,true)) { log::msg("У вас нет прав на изменение",1); return false; }
		    $org = reflex::create("org",array(
		        "heapID" => $heap->id(),
		        "owner" => user::active()->id()
		    ));
		    $redirectURL = $org->url();

	    } else {
		    $org = self::get($p["orgID"]);
		    if(!$org->security(200)) { log::msg("У вас нет прав на изменение",1); return false; }
	    	log::msg("Сохранено");
		}

		$save = array(
			"title",
			"phone",
			"email",
			"url",
			"tags",
			"person",
			"icq",
			"skype",
			"referral"
		);

	    foreach($save as $key)
	    	$org->data($key,$p["data"][$key]);

	    return array(
			"redirectURL"=>$redirectURL,
			"heap" => "{$org->heap()->id()}.{$org->heap()->title()}",
		);

	}

	// Удаляет карточку
	public static function post_delete($p) {
		foreach($p["ids"] as $id) {
		    $org = self::get($id);
		    if($org->security(200)) {
		        $org->data("deleted",1);
		        log::msg("Объект удален");
		    } else {
				log::msg("У вас нет прав на изменение",1);
		    }
	    }
	}

	// ----------------------------------------------------------------------------- Перенос и объединение

	public static function post_merge($p) {

		$orgs = org::all()->eq("id",$p["ids"]);

		foreach($orgs as $org)
		    if(!$org->security(200)) {
			    log::msg("У вас нет прав для совершения данной операции",1);
				return false;
		    }

		$first = $orgs->first();

		$fields = array(
		    "title" => array(),
		    "url" => array(),
		    "email" => array(),
		    "phone" => array(),
		    "tags" => array(),
		    "icq" => array(),
		    "skype" => array(),
		);

		foreach($orgs as $org) {

			foreach($fields as $key=>$val)
		    	$fields[$key][] = $org->data($key);

		    if($org->id()!=$first->id()) {
		        $org->messages()->data("parent","org:{$first->id()}");
		        $org->payments()->data("orgID",$first->id());
		        $org->bills()->data("orgID",$first->id());
		        $org->occupations()->data("orgID",$first->id());
		        $org->delete();
		    }
		}

		foreach($fields as $key=>$val)
		    $first->data($key,implode(" / ",array_unique($val)));

		$first->reflex_repair();

		return true;

	}

}
