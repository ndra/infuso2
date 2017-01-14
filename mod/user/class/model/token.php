<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

/**
 * Модель токена пользователя
 **/
class Token extends ActiveRecord\Record {

	public static function model() {
	
		return array (
			'name' => get_class(),
			'fields' =>
			array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'editable' => '0',
				), array (
					'name' => 'userId',
					'type' => 'link',
					'editable' => '2',
					'label' => 'Пользователь',
					'class' => User::inspector()->className(),
				), array (
					'name' => 'expired',
					'type' => 'datetime',
                    "label" => "Время окончания",
					'editable' => '2',
				), array (
					'name' => 'type',
					'type' => 'textfield',
					'editable' => '2',
					'label' => 'тип',
				), array (
					'name' => 'token',
					'type' => 'string',
					'editable' => '2',
					'label' => 'Токен',
				),
			),
		);
	
	}

    /**
	 * Возвращает все авторизации всех пользователей
 	**/
	public static function all() {
		return service("ar")->collection(get_class());
	}

	public static function get($id) {
		return service("ar")->get(get_class(), $id);
	}

	public function user() {
		return User::get($this->data("userId"));
	}
    
    public function recordParent() {
        return $this->user();
    }

}
