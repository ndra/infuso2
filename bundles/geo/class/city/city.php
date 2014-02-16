<?

/**
 * Модель города
 **/
class geo_city extends reflex {

	

public static function recordTable() {return array (
  'name' => 'geo_city',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'w523me6xyv6d4uio4l6t81rnkuhxpu',
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
      'id' => '2tcehxp96ocv6dc16ofahdmuiq892o',
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
      'id' => 'vbqwvbqmvrq4lhtkai3mvrd4ahqc9r',
      'name' => 'regionID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '1',
      'label' => 'Регион',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'geo_region',
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
	    return self::all()->title("Все города")->param("tab","system");
	}

	public function region() {
		return $this->pdata("regionID");
	}

	public function reflex_parent() {
		return $this->region();
	}

	public function byName($title) {
		return self::all()->eq("title",$title)->one();
	}

	/**
	 * Возвращает координаты города
	 **/
	public function coords() {
		return geo_coder_yandex::getCoords($this->title());
	}
	
}
