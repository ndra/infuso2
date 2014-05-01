<?

namespace Infuso\Cms\User;
use \Infuso\Core;
use \Infuso\ActiveRecord;
use \Infuso\User;

class AuthEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return User\Model\Auth::inspector()->className();
	}

}
