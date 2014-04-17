<?

namespace Infuso\Cms\Reflex\Route;
use Infuso\Core;

/**
 * Отвечает за то что мы видем в каталоге в разделе «Редиректы»
 **/

class Redirect extends \mod_route {

	/**
	 * url => action
	 *  @todo восстановить	 
	 **/
	public function forward($url) {
	
	
		return;
	
		$path = $url->relative();
		$redirect = reflex_redirect::all()->eq("source",$path)->one();
		if($redirect->exists()) {
			return mod::action("reflex_redirect","redirect",array(
			    "target" => $redirect->data("target"),
			));
		}
	}

	public function backward($controller) {}

}
