<?

namespace Infuso\Board;

class TaskEditor extends \reflex_editor {

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Task::all()->title("Задачи");
	}

	public function itemClass() {
	    return "Infuso\\Board\\Task";
	}

	public function beforeEdit() {
	    return \Infuso\Core\Superadmin::check();
	}

}
