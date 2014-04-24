<?

namespace Infuso\Board\Model;

class TaskEditor extends \reflex_editor {

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Task::all()->title("Задачи");
	}
	
	/**
	 * @reflex-child = on
	 **/
	public function customLog() {
	    return $this->item()->getLogCustom()->title("Затраченное время");
	}
	
	/**
	 * @reflex-child = on
	 **/
	public function subtasks() {
	    return $this->item()->subtasks()->title("Подзадачи");
	}

	public function itemClass() {
	    return "Infuso\\Board\\Task";
	}

	public function beforeEdit() {
	    return \Infuso\Core\Superadmin::check();
	}

}
