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
	
	/**
	 * @reflex-root = on
	 **/
	public function operations() {
	    return User\Model\Operation::all()
			->title("Операции");
	}
	
	/**
	 * @reflex-root = on
	 **/
	public function allRoles() {
	    return User\Model\Role::all()
			->title("Роли");
	}

	/**
	 * @reflex-child = on
	 **/
	public function auth() {
	    return $this->item()->authorizations()->title("Авторизации");
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
	    $editor = \Infuso\Cms\Reflex\Editor::get("Infuso\\Cms\\User\\UserEditor:".$p["id"]);
		$this->app()->tmp()->exec("/user/editor/manage", array(
		    "editor" => $editor,
		));
	}
	
	public function listItemTemplate() {
	    return \tmp::get("/user/list-item")
			->param("editor", $this);
	}

    /**
     * Быстрый поиск пользователей работает по нику и email
     **/
    public function applyQuickSearch($collection, $search) {
        $collection->like("email", $search);
        $collection->orr()->like("nickName", $search);
    }

}
