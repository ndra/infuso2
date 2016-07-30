<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

/**
 * Модель авторизации пользователя
 **/
class RoleAttached extends ActiveRecord\Record {

	public static function model() {
	
		return array (
			'name' => 'userRoleAttached',
			'fields' =>
			array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
				), array (
					'name' => 'userId',
					'type' => 'link',
					'label' => 'Пользователь',
					'class' => User::inspector()->className(),
				), array (
					'name' => 'role',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Роль',
					'class' => Operation::inspector()->className(),
				),
			),
		);
	
	}

    /**
	 * Возвращает все авторизации всех пользователей
 	**/
	public static function all() {
		return service("ar")->collection(get_class())->desc("role");
	}

	public static function get($id) {
		return service("ar")->get(get_class(),$id);
	}

	public function user() {
		return $this->pdata("userId");
	}
	
}
