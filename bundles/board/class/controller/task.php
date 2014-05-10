<?

namespace Infuso\Board\Controller;
use Infuso\Board\Model;
use \Infuso\Core;

/**
 * Контроллер для манипуляций с задачами
 **/
class Task extends \Infuso\Core\Controller {

    public function postTest() {
        return \user::active()->exists();
        return true;
    }
    
    public function indexTest() {
        return \user::active()->exists();
        return true;
    }

    /**
     * Контроллер списка задач
     **/
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
        $tasks = Model\Task::all()->orderByExpr($status->order())->limit($limit);
        $tasks->eq("status", $p["status"]);
            
        if($p["status"] != Model\TaskStatus::STATUS_IN_PROGRESS) {
            $tasks->eq("epicParentTask",0);
        }

        // Учитываем поиск
        if($search = trim($p["search"])) {
            $tasks->search($search);
        }
        
        if(($tag = trim($p["tag"])) && $tag!="*") {
            $tasks->useTag($tag);
        }

        $tasks->page($p["page"]);
        
        $html = \tmp::get("/board/shared/task-list/ajax")
            ->param("tasks", $tasks)
            ->getContentForAjax();
        
        return array(
            "html" => $html,
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

    /**
     * Взять задачу
     **/
    public function post_takeTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!\user::active()->checkAccess("board/takeTask",array(
            "task" => $task,
        ))) {
            Core\Mod::msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\TaskStatus::STATUS_IN_PROGRESS);
        $task->logCustom(array(
            "type" => Model\Log::TYPE_TASK_TAKEN,
        ));
    }

    /**
     * Ставит задачу на паузу / снимает с паузы
     **/
    public function post_pauseTask($p) {

        $task = Model\Task::get($p["taskId"]);

        // Параметры задачи
        if(!\user::active()->checkAccess("board/pauseTask",array(
            "task" => $task,
        ))) {
            Core\Mod::msg(\user::active()->errorText(),1);
            return;
        }

        $task->pauseToggle();

    }

    /**
     * Положить задачу обратно
     **/
    public function post_stopTask($p) {

        $task = Model\Task::get($p["taskId"]);
        $time = $p["time"];

        if(!\user::active()->checkAccess("board/stopTask",array(
            "task" => $task,
        ))) {
            Core\Mod::msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\taskStatus::STATUS_BACKLOG);
        $task->logCustom(array(
            "text" => $p["comment"],
            "time" => $time,
            "type" => Model\Log::TYPE_TASK_STOPPED,
        ));

        return true;
    }


}
