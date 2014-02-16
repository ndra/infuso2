<?

/**
 * Класс для сохранения модели формы в базу
 **/
class form_validate extends reflex {

	

public static function recordTable() {return array (
  'name' => 'form_validate',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'mvboyvs7werny5bt41zowgh3me63wu',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'indexEnabled' => '0',
    ),
    1 => 
    array (
      'id' => 's3ylsxwustc1sowesnkuso8l2nkaiq',
      'name' => 'created',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Дата создания',
      'default' => 'now()',
      'indexEnabled' => '0',
    ),
    2 => 
    array (
      'id' => 'y9r3wlioy52nfl2tyvhdf1sxp9s7k5',
      'name' => 'hash',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '2',
      'label' => 'Хэш',
      'indexEnabled' => '1',
    ),
    3 => 
    array (
      'id' => '2xkerd85sqk5hdc5hdmlzxm52qclro',
      'name' => 'formData',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => '2',
      'label' => 'Данные формы',
      'indexEnabled' => '0',
    ),
    4 => 
    array (
      'id' => 'oylinkvsdf5bdyuzd4e6op10j85zxk',
      'name' => 'code',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '2',
      'label' => 'Код',
      'indexEnabled' => '1',
    ),
  ),
  'indexes' => 
  array (
  ),
);}

public static function postTest() {
		return true;
	}

	public static function post_validate($p) {

	    $hash = $p["hash"];
	    $form = self::get($hash)->form();

	    $valid = $form->validate($p["data"]);

		ob_start();
		tmp::exec("form:msg",$form->error());
		$html = ob_get_clean();

	    return array(
	        "valid" => $valid,
	        "name" => $form->errorName(),
	        "html" => $html,
	    );
	}

	/**
	 * Возвращает модель формы
	 **/
	public function form() {
		return form::unserialize($this->data("formData"));
	}

	/**
	 * Возвращает коллекцию всех моделей формы
	 **/
	public static function all() {
		return reflex::get(get_class())->desc("created");
	}

	/**
	 * Возвращает сохраненную формы по хэшу
	 **/
	public static function get($hash) {
		return self::all()->eq("hash",$hash)->one();
	}

	public function reflex_cleanup() {
		return true;
	}

	public function reflex_root() {
		return self::all()->title("Валидация форм")->param("tab","system");
	}
	
}
