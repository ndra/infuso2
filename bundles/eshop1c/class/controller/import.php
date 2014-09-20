<?

namespace Infuso\Eshop1C\Controller;
use \Infuso\Core;
use \Infuso\Eshop1C;

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
	    $done = Exchange::importCatalog();
	    if($done) {
	        Exchange::from(0);
        }
	    return array(
	        "done" => $done,
	        "log" => "Импортировано товаров: ".Exchange::from(),
	    );
	}

	public static function post_offersXML($p) {
	    $done = Exchange::importOffers();
	    if($done) {
	        Eshop1C\Utils::importComplete();
        }
	    return array(
	        "done" => $done,
	        "log" => "Импортировано предложений: ".Exchange::from(),
	    );
	}

	public static function post_start($p) {
	    Exchange::from(0);
	    Eshop1C\Utils::importBegin();
	}

}
