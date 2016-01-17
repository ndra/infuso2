<?

namespace Infuso\Admin\Heartbeat;

/**
 * Стандартная тема модуля admin
 **/
class Theme extends \Infuso\Template\Theme {

	/**
	 * @return Приоритет темы =-1
	 **/
	public function priority() {
		return -1;
	}

	public function path() {
		return self::bundle()->path()."/theme/";
	}

	public function base() {
		return "heartbeat";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "heartbeat";
	}

}
