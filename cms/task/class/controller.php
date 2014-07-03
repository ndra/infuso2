<?

namespace Infuso\Cms\Task;
use Infuso\Core;

/**
 * Стандартная тема модуля Task
 **/

class Controller extends Core\Controller {

	public function postTest() {
	    return Core\Superadmin::check();
	}
	
	public function post_runTask($p) {
	    $task = Task::get($p["taskId"]);
	    $task->exec();
	}

}
