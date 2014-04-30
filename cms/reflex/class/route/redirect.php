<?

namespace Infuso\Cms\Reflex\Route;
use Infuso\Core;

/**
 * Отвечает за то что мы видем в каталоге в разделе «Редиректы»
 **/

class Redirect extends \Infuso\Core\Route {

	/**
	 * url => action
	 *  @todo восстановить	 
	 **/
	public function urlToAction($url) {
	
	
		return;
	
		$path = $url->relative();
		$redirect = reflex_redirect::all()->eq("source",$path)->one();
		if($redirect->exists()) {
			return mod::action("reflex_redirect","redirect",array(
			    "target" => $redirect->data("target"),
			));
		}
	}

	public function actionToUrl($action) {}

}
