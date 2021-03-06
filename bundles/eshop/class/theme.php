<?

/**
 * Стандартная тема для интернет-магазина
 **/

class eshop_theme extends tmp_theme {

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
		return "eshop";
	}

	public function autoload() {
		return true;
	}

	public function name() {
		return "eshop";
	}

}
