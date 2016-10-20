<?

/**
 * Стандартное поведения для класса mod_controller
 **/

class mod_controller_behaviour extends mod_behaviour {

	public static function behaviourPriority() {
		return -10000;
	}

	/**
	 * По умолчанию доступ запрещен
	 **/
	public function indexTest() { return false; }

	/**
	 * По умолчанию при ошибке вызова ф-ции indexTest вводим ошибку 404
	 **/
	public function indexFailed() {
		app()->httpError(404);
	}

	/**
	 * По умолчанию POST запрещен
	 **/
	public function postTest() {
		return false;
	}
    
}
