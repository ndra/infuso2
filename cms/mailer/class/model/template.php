<?

namespace Infuso\Cms\Mailer\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель записи в журнале
 **/ 
class Template extends ActiveRecord\Record {

	public static function model() {
		return array (
			'name' => get_class(),
			'fields' =>	array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					"editable" => 2,
				), array (
					'name' => 'code',
					'type' => 'string',
                    'label' => 'Код',
					"editable" => 1,
				), array (
					'name' => 'from',
					'type' => 'string',
                    'label' => 'От кого',
					"editable" => 1,
				), array (
					'name' => 'subject',
					'type' => 'string',
                    'label' => 'Тема',
					"editable" => 1,
				),  array (
					'name' => 'message',
					'type' => 'textarea',
                    'label' => 'Сообщение',
					"editable" => 1,
				),
			),
		);
	}

    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }

    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("code");
    }

    /**
     * Возвращает пользователя, сделавшего запись
     **/
    public function user() {
        return $this->pdata("user");
    }
    
    /**
     * Возвращает коллекцию писем с этим шаблоном
     **/         
    public function emails() {
        return Mail::all()->eq("code", $this->data("code"));
    }
    
    public function applyTo($mail) {
    }

}
