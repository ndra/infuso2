<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

/**
 * Стандартная тема для heapit
 **/

class Theme extends \Infuso\Template\Theme {

	/**
	 * @return Приоритет темы =-1
	 **/
	public function priority() {
		return -1;
	}

	public function path() {
		return service("classmap")->getClassBundle(get_class())->path()."/theme";
	}
		
	public function base() {
		return "heapit";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "heapit";
	}

}
