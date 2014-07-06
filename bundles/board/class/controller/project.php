<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Project extends Base {
    
    public function index() {
        $this->app()->tm()->exec("/board/projects");
    }
    
    public function index_new() {
        $this->app()->tm()->exec("/board/project-new");
    }

    /**
     * Сохраняет данные проекта
     **/
    public function post_save($p) {
        $project = Model\Project::get($p["projectId"]);
        $project->setData($p["data"]);
        app()->msg("Сохранено");
    }
    
    /**
     * Создает новый проект
     **/         
    public function post_new($p) {
        $project = service("ar")->create(Model\Project::inspector()->className(), $p["data"]);
        return $project->url();
    }
    
    public function post_selectorWindowContent($p) {
        return \tmp::get("/board/shared/project-selector")
            ->getContentForAjax();
    }

}
