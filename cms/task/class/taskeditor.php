<?

namespace Infuso\Cms\Task;
use Infuso\Core;
use Infuso\Cms\Reflex;

class TaskEditor extends Reflex\Editor {

	public function itemClass() {
		return Task::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Task::all()->title("Задачи");
	}
	
    public function viewModes() {
        return array(
            "Таблица" => "/task/grid",
        );
    }

}
