<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

/**
 * Модель авторизации пользователя
 **/
class Auth extends ActiveRecord\Record {

	public static function recordTable() {
	
		return array (
			'name' => 'user_auth',
			'fields' =>
			array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'editable' => '0',
				), array (
					'name' => 'userID',
					'type' => 'link',
					'editable' => '2',
					'label' => 'Пользователь',
					'class' => User::inspector()->className(),
				), array (
					'name' => 'time',
					'type' => 'datetime',
					"default" => "now()",
					'editable' => '2',
				), array (
					'name' => 'cookie',
					'type' => 'textfield',
					'editable' => '2',
					'label' => 'Код (хранится в куках)',
				),
			),
		);
	
	}

    /**
	 * Возвращает все авторизации всех пользователей
 	**/
	public static function all() {
		return \reflex::get(get_class())->desc("time");
	}

	public static function get($id) {
		return \reflex::get(get_class(),$id);
	}

	public function user() {
		return User::get($this->data("userID"));
	}

}