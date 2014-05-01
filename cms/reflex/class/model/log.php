<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Cms\Reflex;

/**
 * Модель записи в журнале
 **/ 
class Log extends ActiveRecord\Record {

	public static function recordTable() {
		return array (
			'name' => 'reflex_log',
			'fields' =>	array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					"editable" => 2,
				), array (
					'name' => 'datetime',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
					'label' => 'Дата',
					"editable" => 2,
					"default" => "now()",
		    	), array (
					'name' => 'user',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Пользователь',
					'class' => 'infuso\\user\\model\\user',
					"editable" => 2,
		    	), array (
					'name' => 'index',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'label' => 'Индекс',
					"editable" => 2,
		    	), array (
					'name' => 'text',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'label' => 'Текст',
					"editable" => 2,
		    	), array (
					'name' => 'type',
					'type' => 'textfield',
					'label' => 'Тип',
					'length' => 30,
					'editable' => 2,
		    	), array (
					'name' => 'p1',
					'type' => 'textfield',
					'editable' => 2,
		    	),
			),
		);
	}

    public static function get($id) {
        return reflex::get(get_class(),$id);
    }

    public static function all() {
        return reflex::get(get_class())->desc("datetime");
    }

    /**
     * Возвращает пользователя, сделавшего запись
     **/
    public function user() {
        return $this->pdata("user");
    }

    /**
     * Возвращает текст сообщения
     **/
    public function text() {
        return $this->data("text");
    }

	/**
	 * Вернет элемент к которому прикреплена запись
	 **/
    public function item() {
        list($class,$id) = explode(":",$this->data("index"));
        return reflex::get($class,$id);
    }

}
