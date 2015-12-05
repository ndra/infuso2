<?

namespace Infuso\Earb;
use \Infuso\Core;

/**
 * Стандартная тема для регистрации / восстановленяи пароля
 **/
class Theme extends \Infuso\template\Theme {

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
		return "earb";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "earb";
	}

}
