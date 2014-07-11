<?

namespace Infuso\CMS\Filter;

/**
 * Стандартная тема модуля filter
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

	public function autoload() {
		return true;
	}

	public function name() {
		return "filter";
	}

}
