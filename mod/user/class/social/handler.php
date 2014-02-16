<?

/**
 * Обработчик событий
 **/
class user_social_handler implements mod_handler {

	/**
	 * @todo рефакторить
	 **/
	public function on_mod_beforeAction() {

		user_social::appendToActiveUser();

	}

}
