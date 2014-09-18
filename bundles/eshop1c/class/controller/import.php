<?

namespace Infuso\Eshop1C\Controller;
use \Infuso\Core;

/**
 * Контроллер ручного режима импорта товаров
 **/ 
class Import extends Core\Controller {

	public static function indexTitle() {
	    return "Ручная загрузка CommerceML";
	}

	public static function indexTest() {
	    return app()->user()->checkAccess("admin");
	}

	public static function postTest() {
	    return app()->user()->checkAccess("admin");
	}

	public static function index() {
	    app()->tm("eshop1c/import")->exec();
	}

	public static function post_importXML($p) {
	    $done = eshop_1c_exchange::importCatalog();
	    if($done) {
	        eshop_1c_exchange::from(0);
        }
	    return array(
	        "done" => $done,
	        "log" => "Импортировано товаров: ".eshop_1c_exchange::from(),
	    );
	}

	public static function post_offersXML($p) {
	    $done = eshop_1c_exchange::importOffers();
	    if($done) {
	        eshop_1c_utils::importComplete();
        }
	    return array(
	        "done" => $done,
	        "log" => "Импортировано предложений: ".eshop_1c_exchange::from(),
	    );
	}

	public static function post_start($p) {
	    eshop_1c_exchange::from(0);
	    eshop_1c_utils::importBegin();
	}

}
