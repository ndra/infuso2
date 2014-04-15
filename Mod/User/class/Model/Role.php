<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

/**
 * роли пользователя
 * @todo выпилить этот класс т.к. вместо него есть user_operation
 **/
class Role extends Core\Component{

	/**
	 * Возвращает коллекцию всех ролей
	 **/
	public static function all() {
	    return Operation::all()->eq("role",true);
	}

	/**
	 * @return Возвращает роль по коду
	 **/
	public static function get($code) {
	    return self::all()->eq("code",$code)->one();
	}
	

	/**
	 * Конструктор роли
	 **/
	public static function create($code,$title=null) {
	    return Core\Mod::service("ar")->create(Operation::inspector()->classname() ,array(
	        "role" => true,
	        "code" => $code,
	        "title" => $title,
		));
	}
	
}
