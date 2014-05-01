<?

namespace Infuso\Cms\Reflex\Controller;
use Infuso\Core;

class Menu extends Core\Controller {

	public function postTest() {
	    return \user::active()->checkAccess("admin:showInterface");
	}

	public function post_root($p) {

	    $tmp = $this->app()->tmp()->template("/reflex/layout/menu/ajax", array(
            "expanded" => $p["expanded"],
		));

        // Пробрасываем url из ajax
        \tmp::param("url", $p["url"]);

		return $tmp->getContentForAjax();
	}

	
	public function post_subdivisions($p) {

	    $tmp = $this->app()->tmp()->template("/reflex/menu-root/subdivisions", array(
	        "nodeId" => $p["nodeId"],
            "expanded" => $p["expanded"],
		));

        // Пробрасываем url из ajax
        \tmp::param("url", $p["url"]);

		return $tmp->getContentForAjax();
	}

}
