<?

/**
 * Модель языка
 **/
class lang extends reflex {

	

public static function recordTable() {return array (
  'name' => 'lang',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => '1r7fahq4ghdcebnm923p5r7k5z7w1i',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    1 => 
    array (
      'id' => 'ixk1z341rnflsxp52nkg6dy9hqkv63',
      'name' => 'priority',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    2 => 
    array (
      'id' => 'nf9itflh7waitmehqy107k5ho8lidf',
      'name' => 'name',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Сокращенное английское название',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    3 => 
    array (
      'id' => 'f927fl2nmvboyvs7werny5bt41zowg',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Название',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    4 => 
    array (
      'id' => '963852j8lsdw1romuz74vhdcuh7mgb',
      'name' => 'img',
      'type' => 'knh9-0kgy-csg9-1nv8-7go9',
      'editable' => '1',
      'label' => 'Изображение / иконка',
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

/**
	 * Возвращает список языков
	 **/
	public static function all() {
		return reflex::get(get_class())->asc("priority")->param("sort",true);
	}

	/**
	 * Возвращает язык по его id
	 **/
	public static function get($id) {
		return reflex::get(get_class(),$id);
	}

	public function reflex_title() {
	    $ret = $this->data("title");
	    if(!$ret)
			$ret = $this->data("name");
	    return $ret;
	}

	/**
	 * Мета-данные у языков выключены
	 **/
	public function reflex_meta() {
		return false;
	}

	/**
	 * Возвращает фразу с ключем $key, переведенную на данный язык.
	 **/
	public function tr($key) {
		$ph = lang_phrase::search($key);
		return $ph->pdata("replace");
	}

	/**
	 * Возвращает активный язык.
	 **/
	public function active() {
		$lang = mod::session("lang");
		$item = self::get($lang);
		if(!$item->exists())
			$item = self::all()->one();
		return $item;
	}

	/**
	 * Делает текущий язык активным
	 **/
	public function activate() {
		if($this->exists())
			mod::session("lang",$this->id());
	}

	/**
	 * @return Возвращает сокращенное название языка, например, 'en'
	 * Это название редактируется в каталоге
	 **/
	public function name() {
		return $this->data("name");
	}

	public static function reflex_root() {
	
		if(mod_superadmin::check()) {
			return array(
				self::all()->title("Языки")->param("tab","system"),
			);
		}
			
		return array();
	}

	public function reflex_url() {
		return mod_action::get("lang_controller","set",array("lang"=>$this->id()))->url();
	}

	/**
	 * Возвращает файл иконки языка
	 **/
	public function img() {
		return $this->pdata("img");
	}

}
