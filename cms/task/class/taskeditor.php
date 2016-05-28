<?

namespace Infuso\Cms\Task;
use Infuso\Core;

class TaskEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
		return Task::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Task::all()->asc("class")
            ->asc("method", true)
            ->title("Задачи");
	}
	
    public function listItemTemplate() {
        return app()
            ->tm("/task/list-item")
            ->param("editor", $this);
    }
    
    public function filters($collection) {
        return array (
            "Активные" => $collection->copy()->eq("completed", 0),
            "Выполненные" => $collection->copy()->eq("completed", 1),
            "Все задачи" => $collection->copy(),
        );
    }

}
