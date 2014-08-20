<?

/**
 * Модель-заглушка
 * используется при попытке создать объект несуществующего класса
 **/
class reflex_none extends \Infuso\ActiveRecord\Record {

	public static function recordTable() {
		return null;
	}
	
	public function reflex_title() {
	    return "non-existing class";
	}

}
