<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Стандартная тема модуля tmp
 **/

class defaultTheme extends Theme {

	/**
	 * @return Приоритет темы =-1
	 **/
	public function priority() {
		return -1;
	}

	public function path() {
		return self::inspector()->bundle()->path()."/theme";
	}

	public function base() {
		return "tmp";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "tmp";
	}

}
