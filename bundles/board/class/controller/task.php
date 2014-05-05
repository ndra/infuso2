<?

namespace Infuso\Board\Controller;

use Infuso\Board\Model;
use \Infuso\Core;

class Task extends \Infuso\Core\Controller {

    public function postTest() {
        return \user::active()->exists();
        return true;
    }
    
    public function indexTest() {
        return \user::active()->exists();
        return true;
    }

    public function index_listTasks($p) {
        $this->app()->tmp()->exec("/board/task-list",array(
            "status" => $p["status"],
        ));
    }
    
    /**
     * Возвращает html списка заадч
     **/
    public function post_getTasks($p) {

        $limit = 40; 
        
        // Статус для которого мы смотрим задачи
        $status = Model\TaskStatus::get($p["status"]);
        // Полный список задач
        $tasks = Model\Task::visible()->orderByExpr($status->order())->limit($limit);
        $tasks->eq("status", $p["status"]);

        if($p["parentTaskID"]) {

            $tasks = $tasks->eq("epicParentTask",$p["parentTaskID"])->orderByExpr("`status` != 1")->asc("priority",true);
            $tasks->eq("status",array(Model\TaskStatus::STATUS_NEW,Board\TaskStatus::STATUS_IN_PROGRESS))
                ->orr()->gt("changed",\util::now()->shift(-60));

        } else {
        
            $tasks->eq("status",$p["status"]);
            
            if($p["status"] != Model\TaskStatus::STATUS_IN_PROGRESS) {
                $tasks->eq("epicParentTask",0);
            }
            
        }

        // Учитываем поиск
        if($search = trim($p["search"])) {
        
            $search2 = \util::str($search)->switchLayout();

            $tasks->joinByField("projectID");
            $tasks->like("text",$search)
                ->orr()->like("Infuso\\Board\\Model\\Project.title",$search)
                ->orr()->like("text",$search2)
                ->orr()->like("Infuso\\Board\\Model\\Project.title",$search2);
        }
        
        if(count($p["projects"])){
            $tasks->eq("projectID", $p["projects"]);
        }
        
        if(($tag = trim($p["tag"])) && $tag!="*") {
            $tasks->useTag($tag);
        }

        $tasks->page($p["page"]);

        $lastChange = null; 
       
        
        $ret = \tmp::get("/board/shared/task-list/ajax")
            ->param("tasks", $tasks)
            ->getContentForAjax();
            
        
        return array(
            "html" => $ret,
            "pages" => $tasks->pages(),
        );
                  
    }

    /**
     * Возвращает html формы редактирования задачи.
     * Используется в диалоге, который открывается если кликнуть на карточку задачи.
     **/
    public function post_getTask($p) {

        $task = \Infuso\Board\Model\Task::get($p["taskId"]);

        $html = \tmp::get("/board/task")
            ->param("task", $task)
            ->getContentForAjax();

        return $html;

    }

}
