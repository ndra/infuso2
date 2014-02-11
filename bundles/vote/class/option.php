<?

/**
 * Модель варианта ответа на вопрос
 **/
class vote_option extends reflex implements mod_handler {

	

public static function reflex_table() {return array (
  'name' => 'vote_option',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => '78ebxcebqpu2oyahqyg0dk9sxwu0tw',
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
      'id' => 'g6qk12xfgroye2dm96dwlztk1rx4a2',
      'name' => 'voteID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'vote',
      'collection' => '',
      'titleMethod' => '',
    ),
    2 => 
    array (
      'id' => 'g0nkuz78923fvsn812oygzdcuhjpu6',
      'name' => 'priority',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    3 => 
    array (
      'id' => '1hdfg0op52x4e6d49074ebnflz3c5i',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Текст ответа',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    4 => 
    array (
      'id' => 'klbqclz7c1hnm50twesqc5znk903ml',
      'name' => 'count',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '2',
      'label' => 'Количество ответов',
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
	 * Возвращает коллекцию всех вариантов ответа
	 **/
	public static function all() {
		return reflex::get(get_class())->asc("priority");
	}

	/**
	 * Возвращает вариант ответа по ID
	 **/
	public static function get($id) {
		return reflex::get(get_class(),$id);
	}

	/**
	 * Возвращает родительский объект голосования
	 **/
	public function reflex_parent() {
		return $this->vote();
	}

	/**
	 * Возвращает родительский объект голосования
	 **/
	public function vote() {
		return $this->pdata("voteID");
	}

	/**
	 * Возвращает коллекцию ответов пользователей, выбравших этот вариант
	 **/
	public function answers() {
		return $this->vote()->answers()->eq("optionID",$this->id());
	}

	/**
	 * Возвращает количество ответов пользователей, выбравших этот вариант
	 **/
	public function count() {
		return $this->answers()->count();
	}

	/**
	 * Возвращает процент ответов пользователей, выбравших этот вариант
	 * Результат округляется до сотых
	 **/
	public function percent() {
		$ret = $this->count() / $this->vote()->answers()->count();
		$ret*=100;
		$ret = number_format($ret,2,".","");
		return $ret;
	}

	/**
	 * При изменении ответов, обновляем количество ответов в базе
	 **/
	public function on_vote_answersChanged($p) {
		$p->param("option")->updateCount();
	}

	/**
	 * Обновляет количество ответов с данным вариантом, которое хранится в поле таблицы
	 **/
	public function updateCount() {
		$count = $this->answers()->count();
		$this->data("count",$count);
	}

	public function reflex_repair() {
		$this->updateCount();
	}

}
