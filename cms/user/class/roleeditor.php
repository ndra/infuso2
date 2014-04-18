<?

namespace Infuso\Cms\User;
use \Infuso\Core;
use \Infuso\ActiveRecord;
use \Infuso\User;

class RoleEditor extends \Infuso\Cms\Reflex\Editor {

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return User\Model\RoleAttached::all()->title("Присоединенные роли");
	}

	public function itemClass() {
	    return User\Model\RoleAttached::inspector()->className();
	}

}
