<?

namespace Infuso\Board\Model;
use Infuso\Core;

class TaskEditor extends \Infuso\Cms\Reflex\Editor {

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Task::all()->title("Задачи")->param("group", "Доска");
	}
	
	public function itemClass() {
	    return Task::inspector()->className();
	}

	public function beforeEdit() {
	    return Core\Superadmin::check();
	}

}
