<?

class board_handler_autocomplete implements \Infuso\Core\Handler {

	/**
	 * @handler = infusoDeploy
	 **/
    public function deploy() {
        reflex_task::add(array(
            "class" => get_class(),
            "method" => "createAutocompleteTask",
            "crontab" => "0 0 * * *",
		));
    }
    
    public static function createAutocompleteTask() {
        reflex_task::add(array(
            "class" => "board_task",
            "query" => "status=".board_task_status::STATUS_CHECKOUT."",
            "method" => "tryAutocomplete",
		));
    }

}
