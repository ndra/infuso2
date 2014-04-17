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
		    Core\Mod::msg("Электронная почта изменена");
		}
	}
	
	public function post_changePassword($p) {

	    $user = \user::get($p["userId"]);
		if($user->changePassword($p["password"])) {
		    Core\Mod::msg("Пароль изменен");
		    return true;
		}
		
	}

}
