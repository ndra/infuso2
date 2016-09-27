<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Main extends Base {

    public function controller() {
        return "board";
    }

    public function index() {
        app()->tm("/board/task-list")
            ->param("status", "backlog")
			->exec();
    }
    
    /**
     * Просмотр задачи
     **/
    public function index_task($p) {
    
        $taskId = (int) $p["id"];
		$group = Pseudogroup::byTask($taskId);
        app()->tm("/board/task-list")
            ->param("status", $group->id())
            ->param("task", $taskId)
			->exec();
    }
    
    public function index_request() {
        app()->tm("/board/task-list")
            ->param("status", "request")
			->exec();
    }
    
    public function index_backlog() {
        app()->tm("/board/task-list")
            ->param("status", "backlog")
			->exec();
    }
    
    public function index_inprogress() {
        app()->tm("/board/task-list")
            ->param("status", "inprogress")
			->exec();
    }
    
    public function index_checkout() {
        app()->tm("/board/task-list")
            ->param("status", "checkout")
			->exec();
    }
    
    public function index_completed() {
        app()->tm("/board/task-list")
            ->param("status", "completed")
			->exec();
    }
    
    public function index_cancelled() {
        app()->tm("/board/task-list")
            ->param("status", "cancelled")
			->exec();
    }
    
    public function index_problem() {
        app()->tm("/board/task-list")
            ->param("status", "problem")
			->exec();
    }

}
