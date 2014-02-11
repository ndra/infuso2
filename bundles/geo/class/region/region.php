<?

/**
 * Модель региона для модуля geo
 **/
class geo_region extends reflex {

	

public static function reflex_table() {return array (
  'name' => 'geo_region',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => '5rxpuz7we0dwgbn89z78gbxy9i7cei',
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
      'id' => 'qf1hxkvznw16xw1s34g0dyv2qyuix4',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => '',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    2 => 
    array (
      'id' => 'iqku0omlh3mlznpezjk9idf5inp9b7',
      'name' => 'countryID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '1',
      'label' => 'Страна',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'geo_country',
      'collection' => '',
      'titleMethod' => '',
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
	    return self::all()->title("Все регионы")->param("tab","system");
	}

	public function country() {
		return $this->pdata("countryID");
	}

	public function reflex_parent() {
		return $this->country();
	}
	
	public function byName($title) {
		return self::all()->eq("title",$title)->one();
	}

	public function cities() {
		return geo_city::all()->eq("regionID",$this->id());
	}

	public function reflex_children() {
		return array(
			$this->cities()->title("Города"),
		);
	}
	
}
