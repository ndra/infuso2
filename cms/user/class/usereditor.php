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
	 * @reflex-tab = system
	 **/
	public function operations() {
	    return User\Model\Operation::all()
			->title("Операции");
	}
	
	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function allRoles() {
	    return User\Model\Role::all()
			->title("Роли");
	}
    

	/**
	 * @reflex-child = on
	 **/
	public function tokens() {
	    return $this->item()->tokens()->title("Токены");
	}

	/**
	 * @reflex-child = on
	 **/
	public function auth() {
	    return $this->item()->authorizations()->title("Авторизации");
	}
	
	public function layout() {
	    return array(
	        "tmp:/user/editor/manage/content",
	        "<div style='border-bottom: 3px solid #ccc' ></div>",
	        "form",
		);
	}
	
	public function listItemTemplate() {
	    return app()->tm("/user/list-item")
			->param("editor", $this);
	}

    /**
     * Быстрый поиск пользователей работает по нику и email
     **/
    public function applyQuickSearch($collection, $search) {
        $collection->like("email", $search);
        $collection->orr()->like("nickName", $search);
    }
    
    public function filters($collection) {    
        $ret = array();
        $ret["Все"] = $collection->copy();
        $ret["Подтвержденные"] = $collection->copy()->eq("verified", true);
        $ret["Неподтвержденные"] = $collection->copy()->eq("verified", false);
        return $ret;    
    }


}
