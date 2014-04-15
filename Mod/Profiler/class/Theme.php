<?

namespace Infuso\Profiler;

class Theme extends \tmp_theme {

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
		return "infuso/profiler";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "profiler";
	}

}
