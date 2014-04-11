<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Org extends Base {

	public function index() {
	    $this->app()->tmp()->exec("/heapit/index");
	}

	public function index_add() {
	    $this->app()->tmp()->exec("/heapit/org-new");
	}

	/**
	 * Создает контрагента
	 **/
	public static function post_new($p) {

		if(!$p["data"]["title"]) {
		    Core\Mod::msg("Название не указано",1);
		    return false;
		}

	    $org = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Org", $p["data"]);
		return $org->url();

	}
	

	// Вносит изменения в карточку
	public static function post_save($p) {

		if(!$p["data"]["title"]) {
		    log::msg("Название не указано",1);
		    return false;
		}

	    $org = \Infuso\Heapit\Model\Org::get($p["orgId"]);
		$save = array(
			"title",
			"phone",
			"email",
			"url",
			"person",
			"icq",
			"skype",
			"referral"
		);

	    foreach($save as $key) {
	    	$org->data($key,$p["data"][$key]);
	    }
	    
		Core\Mod::msg("Сохранено");
	}

	/**
	 * Возвращает html-код списка контрагентов
	 **/
	public function post_search($p) {

	    $items = \Infuso\Heapit\Model\Org::all();
	    $items->page($p["page"]);

	    // Учитываем поиск по имени
	    if($search = trim($p["search"])) $items->like("title","$search");

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

	    $ret = \tmp::get("/heapit/index/org-list/ajax")
			->param("orgs", $items)
			->getContentForAjax();
		
		return $ret;
		
	}

}
