<?

namespace Infuso\Board\Model;
use Infuso\Core;

class TaskEditor extends \Infuso\Cms\Reflex\Editor {

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
	    return Task::inspector()->className();
	}

	public function beforeEdit() {
	    return Core\Superadmin::check();
	}

}
