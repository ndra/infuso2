<?

namespace Infuso\Poll\Model;

/**
 * Модель варианта ответа на вопрос
 **/
class Option extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => 'vote_option',
            'fields' => array ( 
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'pollId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'class' => Poll::inspector()->className(),
                ), array (
                    'name' => 'priority',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'indexEnabled' => '1',
                ), array (
                    'name' => 'title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Текст ответа',
                    'indexEnabled' => '1',
                ), array (
                    'name' => 'draft',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'label' => 'Пользовательский',
                    'editable' => 1,
                ), array (
                    'name' => 'count',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'editable' => '2',
                    'label' => 'Количество ответов',
                ),
            ),
        );
    }

	/**
	 * Возвращает коллекцию всех вариантов ответа
	 **/
	public static function all() {
		return service("ar")->collection(get_called_class())->asc("priority");
	}

	/**
	 * Возвращает вариант ответа по ID
	 **/
	public static function get($id) {
		return service("ar")->get(get_called_class(),$id);
	}

	/**
	 * Возвращает родительский объект голосования
	 **/
	public function recordParent() {
		return $this->vote();
	}

	/**
	 * Возвращает родительский объект голосования
	 **/
	public function vote() {
		return $this->pdata("pollId");
	}

	/**
	 * Возвращает коллекцию ответов пользователей, выбравших этот вариант
	 **/
	public function answers() {
		return $this->vote()->answers()->eq("optionId",$this->id());
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

}
