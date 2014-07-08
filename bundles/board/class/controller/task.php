<?

namespace Infuso\Board\Controller;
use Infuso\Board\Model;
use \Infuso\Core;

/**
 * Контроллер для манипуляций с задачами
 **/
class Task extends Base {

    /**
     * Контроллер списка задач
     **/
    public function index_listTasks($p) {
        $this->app()->tm()->exec("/board/task-list",array(
            "status" => $p["status"],
        ));
    }
    
    public function index_new() {
        app()->tm()->exec("/board/task-new");
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
            
        // Учитываем поиск
        if($search = trim($p["search"])) {
            $tasks->search($search);
        }
        
        if(($tag = trim($p["tag"])) && $tag!="*") {
            $tasks->useTag($tag);
        }

        $tasks->page($p["page"]);
        
        $html = \tmp::get("/board/widget/task-list/ajax")
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
        $html = \tmp::get("/board/task/content")
            ->param("task", $task)
            ->getContentForAjax();
        return array(
			"html" => $html,
			"taskURL" => $task->url(),
		);
    }
    
    /**
     * Создает новую задачу
     **/         
    public function post_newTask($p) {
        $task = service("ar")->create("\\Infuso\\Board\\Model\\Task", $p["data"]); 
        
        app()->msg($p);
              
        return array(
			"url" => $task->url(),
		);
    }

    public function post_saveTask($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        $task->setData($p["data"]);
        app()->msg("Задача изменена");
    }
    
    public function post_timeInputContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/time-input-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }

    /**
     * Взять задачу
     **/
    public function post_takeTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!\user::active()->checkAccess("board/takeTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }
        
        $task->take(app()->user());

		// Меняем статус задачи
        /*$task->data("status",Model\TaskStatus::STATUS_IN_PROGRESS);
        // Записываем изменения статуса в лог
        $task->logCustom(array(
            "type" => Model\Log::TYPE_TASK_TAKEN,
        ));  */
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
            app()->msg(\user::active()->errorText(),1);
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
            app()->msg(\user::active()->errorText(),1);
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
    
    /**
     * Задача выполнена
     **/
    public function post_doneTask($p) {

        $task = Model\Task::get($p["taskId"]);
        $time = $p["time"];

        if(!\user::active()->checkAccess("board/doneTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\taskStatus::STATUS_DONE);
        $task->logCustom(array(
            "text" => $p["comment"],
            "time" => $time,
            "type" => Model\Log::TYPE_TASK_DONE,
        ));

        return true;
    }


}
