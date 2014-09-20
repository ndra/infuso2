<?

namespace Infuso\Eshop1C;
use \Infuso\Core;

/**
 * Тема выгрузки в 1С
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
		return "eshop1c";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "eshop1c";
	}

}
