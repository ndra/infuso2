<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Projects extends Base {
    
    public function index() {
        $this->app()->tmp()->exec("/board/projects");
    }
    
    public function index_new() {
        $this->app()->tmp()->exec("/board/project-new");
    }

    /**
     * Сохраняет данные проекта
     **/
    public function post_save($p) {
        $project = Model\Project::get($p["projectId"]);
        $project->setData($p["data"]);
        app()->msg("Сохранено");
    }

}
