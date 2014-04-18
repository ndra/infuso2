<?

namespace Infuso\Cms\User;
use \Infuso\Core;
use \Infuso\ActiveRecord;
use \Infuso\User;

class OperationEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return User\Model\Operation::inspector()->className();
	}

}
