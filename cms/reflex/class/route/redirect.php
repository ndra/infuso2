<?

namespace Infuso\Cms\Reflex\Route;
use Infuso\Core;

/**
 * Отвечает за то что мы видем в каталоге в разделе «Редиректы»
 **/
class Redirect extends \Infuso\Core\Route {

	public function priority() {
		return 0;
	}

	/**
	 * url => action
	 *  @todo восстановить	 
	 **/
	public function urlToAction($url) {
        
        $path = $url->relative();
        $path = "/".trim($path, "/");
        
		$redirect = \Infuso\Cms\Reflex\Model\Redirect::all()->eq("source", $path)->one();
        
		if($redirect->exists()) {
			return \Infuso\Core\Action::get("Infuso\\Cms\\Reflex\\Model\\Redirect", "redirect", array (
			    "target" => $redirect->data("target"),
			));
		}
	}

	public function actionToUrl($action) {}

}
