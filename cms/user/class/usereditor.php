<?

namespace Infuso\Cms\User;
use \Infuso\Core;
use \Infuso\ActiveRecord;
use \Infuso\User;

class UserEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return User\Model\User::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 **/
	public function userList() {
	    return User\Model\User::all()
			->title("Пользователи");
	}
	
	public function menu() {
	    $menu = parent::menu();
		$menu[] = array(
            "href" => \mod::action(get_class($this),"manage",array("id"=>$this->itemID()))->url(),
            "title" => "Управление",
        );
	    return $menu;
	}
	
	/**
	 * Контроллер управления пользователем: изменение email и пароля
	 **/
	public function index_manage($p) {
	    $editor = \Infuso\Cms\Reflex\Editor::get("Infuso\\User\\Model\\UserEditor:".$p["id"]);
		$this->app()->tmp()->exec("/user/editor/manage", array(
		    "editor" => $editor,
		));
	}

}
