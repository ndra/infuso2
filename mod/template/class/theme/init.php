<?

/**
 * Сборщик описаний тем
 **/
class tmp_theme_init extends mod_init {

	public function priority() {
		return 1;
	}

	/**
	 * Составляет список файлов в каждой из тем для быстрого поиска шаблона
	 **/
	public function init() {

		mod::msg("Init themes");

		// Очищаем карту тем
		file::get(tmp_theme::mapFolder())->delete(1);
		file::mkdir(tmp_theme::mapFolder());

    	// Собираем спислк классов тем и сортируем их по приоритету
    	$themes = array();
		foreach(mod::service("classmap")->classes("Infuso\\Template\\Theme") as $class) {
	        $themes[] = new $class();
		}
		usort($themes, function($a,$b) {
			return $a->priority() - $b->priority();
		});

		$autoload = array();

		foreach($themes as $theme) {
		    $map = $theme->buildMap();
		    if($theme->autoload()) {
		        $autoload += $map;
			}
		}

		util::save_for_inclusion(tmp_theme::mapFolder()."/"."_autoload.php",$autoload);

	}

}
