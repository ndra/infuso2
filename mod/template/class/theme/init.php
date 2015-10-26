<?

/**
 * Сборщик описаний тем
 **/
class tmp_theme_init implements mod_handler {

	/**
	 * Составляет список файлов в каждой из тем для быстрого поиска шаблона
    * @handler = infuso/deploy
	 **/
	public function deploy() {

		app()->msg("Init themes");

		// Очищаем карту тем
		file::get(tmp_theme::mapFolder())->delete(1);
		file::mkdir(tmp_theme::mapFolder());

    	// Собираем список классов тем и сортируем их по приоритету
    	$themes = array();
		foreach(service("classmap")->classes("Infuso\\Template\\Theme") as $class) {
	        $themes[] = new $class();
		}
        
		foreach($themes as $theme) {
		    $theme->compile();
		}
        
        self::buildAutoload();

	}
    
    public function buildAutoload() {
    
    	// Собираем список классов тем и сортируем их по приоритету
    	$themes = array();
		foreach(service("classmap")->classes("Infuso\\Template\\Theme") as $class) {
	        $themes[] = new $class();
		}
		usort($themes, function($a,$b) {
			return $a->priority() - $b->priority();
		});

		$autoload = array();

		foreach($themes as $theme) {
		    if($theme->autoload()) {
		        foreach($theme->map() as $key => $val) {
		        	$autoload[$key] = $val;
		        }
			}
		}

		util::save_for_inclusion(tmp_theme::mapFolder()."/"."_autoload.php",$autoload);
    
    }

}
