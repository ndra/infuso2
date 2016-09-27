<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Project extends Base {
    
    public function index() {   
        app()->tm()->exec("/board/projects");
    }
    
    public function index_new() {
        app()->tm()->exec("/board/project-new");
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
    
    /**
     * Контент для окна выбора проекта
     **/         
    public function post_selectorWindowContent($p) {
        return \tmp::get("/board/shared/project-selector")
            ->getContentForAjax();
    }
    
    public function post_listProjects($p) {
        $ret = array(
            "items" => array(),
        );
        $projects = Model\Project::all()->visible()->like("title", $p["query"]);
        foreach($projects as $project) {
            $ret["items"][] = array(
                "id" => $project->id(),
                "title" => $project->title(), 
            );
        }
        return $ret;
    }

}
