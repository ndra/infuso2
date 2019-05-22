<?

namespace Infuso\Site;

/**
 * Тема модуля site
 **/

class Theme extends \Infuso\Template\Theme {

	public function path() {
		return self::inspector()->bundle()->path()."/theme/";
	}

	public function base() {
		return "";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "site";
	}

}
