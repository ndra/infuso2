<?

namespace Infuso\Cms\Reflex\Controller;
use Infuso\Core;

class Menu extends Core\Controller {

	public function postTest() {
	    return \user::active()->checkAccess("admin:showInterface");
	}
	
	public function post_subdivisions($p) {
	    $tmp = $this->app()->tmp()->template("/reflex/menu-root/subdivisions", array(
	        "nodeId" => $p["nodeId"],
		));
		return $tmp->getContentForAjax();
	}

}
