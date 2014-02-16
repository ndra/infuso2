<?

/**
 * Модель страны для модуля geo
 **/
class geo_country extends reflex {

	

public static function recordTable() {return array (
  'name' => 'geo_country',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => '7fuh38ub3m16tp9stmu2qkl6xk10xm',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'group' => '',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    1 => 
    array (
      'id' => '12xpe23yvbxkg2dka2o4vhn8103k9i',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Название',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
  ),
  'indexes' => 
  array (
  ),
);}

public static function all() {
	    return reflex::get(get_class())->asc("title");
	}

	public static function get($id) {
		return reflex::get(get_class(),$id);
	}

	public static function reflex_root() {
	    return self::all()->title("Все страны")->param("tab","system");
	}

	/**
	 * Возвращает коллекцию регионов для страны
	 **/
	public function regions() {
		return geo_region::all()->eq("countryID",$this->id());
	}

	public function reflex_children() {
		return array(
			$this->regions()->title("Регионы"),
		);
	}
	
}

