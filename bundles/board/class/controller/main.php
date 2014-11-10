<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class Main extends Base {

    public function controller() {
        return "board";
    }

    public function index() {
        $this->app()->tm("/board/task-list")
            ->param("status", "backlog")
			->exec();
    }
    
    public function index_request() {
        $this->app()->tm("/board/task-list")
            ->param("status", "request")
			->exec();
    }
    
    public function index_backlog() {
        $this->app()->tm("/board/task-list")
            ->param("status", "backlog")
			->exec();
    }
    
    public function index_inprogress() {
        $this->app()->tm("/board/task-list")
            ->param("status", "inprogress")
			->exec();
    }
    
    public function index_checkout() {
        $this->app()->tm("/board/task-list")
            ->param("status", "checkout")
			->exec();
    }
    
    public function index_completed() {
        $this->app()->tm("/board/task-list")
            ->param("status", "completed")
			->exec();
    }
    
    public function index_cancelled() {
        $this->app()->tm("/board/task-list")
            ->param("status", "cancelled")
			->exec();
    }

}
