<?

namespace Infuso\Cms\User;
use \Infuso\Core;
use \Infuso\User\Model\User;

class Controller extends \Infuso\Core\Controller {

	public function postTest() {
	    return true;
	}
	
	public function post_changeEmail($p) {
	    $user = \user::get($p["userId"]);
		if($user->changeEmail($p["newEmail"])) {
		    app()->msg("Электронная почта изменена");
		}
	}
	
	public function post_changePassword($p) {

	    $user = \user::get($p["userId"]);
		if($user->changePassword($p["password"])) {
		    app()->msg("Пароль изменен");
		    return true;
		}
		
	}

    public function post_addRole($p) {
        user::get($p["userId"])->addRole($p["role"]);
        return true;
    }

    public function post_removeRole($p) {
        user::get($p["userId"])->removeRole($p["role"]);
        return true;
    }

    public function post_getRolesAjax($p) {
        return \tmp::get("/user/editor/manage/content/roles/ajax")
            ->param("user", \user::get($p["userId"]))
            ->getContentForAjax();
    }
    
    public function post_loginAs($p) {
        $user = service("user")->get($p["userId"]);
        $user->activate();
        app()->msg("Вы вошли как ".$user->title());
    }

}
