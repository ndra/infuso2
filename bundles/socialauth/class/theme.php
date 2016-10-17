<?

namespace Infuso\UserActions;
use \Infuso\Core;

/**
 * Стандартная тема социальной авторизации
 **/
class SocialAuth extends \Infuso\Template\Theme {

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
		return "socialauth";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "socialauth";
	}

}
