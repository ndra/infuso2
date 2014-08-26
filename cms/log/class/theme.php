<?

namespace Infuso\CMS\Log;
use \Infuso\Core;

/**
 * тема бандла form
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
		return "log";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "log";
	}

}
