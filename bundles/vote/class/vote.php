<?

/**
 * Модель опроса
 **/
class vote extends reflex {

	

public static function reflex_table() {return array (
  'name' => 'vote',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'mi9fbjqe20qv2sc5twgqvg8muynoeb',
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
      'id' => '1stc9z3plz7pg6t4eix4a6jkg2t810',
      'name' => 'created',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Дата создания',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    2 => 
    array (
      'id' => 'apfhfqfgf4712pqb6hmws4yknthxch',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Вопрос',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    3 => 
    array (
      'id' => 'pgznwvsdpahdmasqkgzxwazdwurxkl',
      'name' => 'active',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Голосование активно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    4 => 
    array (
      'id' => '1i1rnvb01yal9etjhenafnrxhl3r1i',
      'name' => 'mode',
      'type' => 'fahq-we67-klh3-456t-plbo',
      'editable' => '1',
      'label' => 'Режим',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'list' => 'Разрешен один ответ, Разрешено несколько ответов, Произвольные значения',
      'method' => '',
    ),
  ),
  'indexes' => 
  array (
  ),
);}

/**
	 * @return Возвращает коллекцию всех опросов
	 **/
	public static function allEvenHidden() {
	    return reflex::get(get_class())
	        ->desc("active")
	        ->desc("created",true)
	        ->param("icon","hand");
	}

	/**
	 * @return Возвращает коллекцию всех опросов
	 **/
	public static function all() {
	    return self::allEvenHidden()->eq("active",1);
	}

	/**
	 * @return Возвращает опрос по id
	 **/
	public static function get($id) {
	    return reflex::get(get_class(),$id);
	}

	/**
	 * @return Возвращает последний активный опрос
	 **/
	public static function last() {
	    return self::all()->eq("active",1)->one();
	}

	/**
	 * @return Возвращает коллекцию вариантова ответа на вопрос
	 **/
	public function options() {
	    return vote_option::all()->eq("voteID",$this->id());
	}

	public function reflex_children() { return array(
	    $this->options()->title("Варианты ответа")->param("sort",true),
	    $this->answers()->title("Ответы пользователей"),
	);}

	public function reflex_beforeCreate() {
	    $this->data("created",util::now());
	}

	/**
	 * @return Коллекция ответов на данный вопрос
	 **/
	public function answers() {
	    return vote_answer::all()->eq("voteID",$this->id());
	}

	/**
	 * Добавляет ответ в вопрос
	 * @param $optionID - id варианта ответа
	 * @param $cookie - cookie-ключ для защиты от повторного голосования
	 **/
	public function addAnswer($optionID,$cookie) {

		if(!$this->data("active")) {
		    mod::msg("Голосование закрыто",1);
		    return;
		}

		$option = $this->options()->eq("id",$optionID)->one();
		if(!$option->exists()) {
		    mod::msg("Недопустимый вариант ответа",1);
		    return;
		}

		$this->answers()->create(array(
			"optionID" => $option->id(),
			"cookie" => $cookie
		));

	}

	/**
	 * Добавляет вариант ответа ввиде текста
	 **/
	public function addText($text,$cookie) {

		// Нормализуем текст
		// Это даст нам больше шансов что одинаковые ответы объединятся
		$text = util::str($text)->trim()->text()."";

		if(!$text) {
		    mod::msg("Недопустимый вариант ответа");
			return;
		}

		$option = $this->options()->eq("lower(title)",$text)->one();
		if(!$option->exists())
			$option = $this->options()->create(array(
			    "title" => $text
			));

		$this->addAnswer($option->id(),$cookie);
	}

	/**
	 * Возвращает cookie-ключ, уникальный для каждого пользователя
	 **/
	public function getCookie() {
	    $key = "5g03f90jfv03f5btmvz";
		$cookie = mod::cookie($key);
		if(!$cookie) {
		    $cookie = util::id(20);
		    mod::cookie($key,$cookie);
		}
		return $cookie;
	}

	/**
	 * true, если пользователь проголосовал за последние 24 часа
	 **/
	public function voted() {
	    return !!$this->answers()->eq("cookie",self::getCookie())->count();
	}

}
