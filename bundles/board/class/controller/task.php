<?

namespace Infuso\Board\Controller;
use Infuso\Board\Model;
use \Infuso\Core;

/**
 * Контроллер для манипуляций с задачами
 **/
class Task extends Base {

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
        
        $html = app()->tm("/board/widget/task-list/ajax")
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
        $html = app()->tm("/board/task/content")
            ->param("task", $task)
            ->getContentForAjax();
        return array(
			"html" => $html,
			"taskURL" => $task->url(),
		);
    }
    
    public function post_newTaskWindow() {
        return array(
			"html" => app()->tm("/board/task-new")->getContentForAjax(),
		);
    }
    
    /**
     * Создает новую задачу
     **/         
    public function post_newTask($p) {
        $task = service("ar")->create("\\Infuso\\Board\\Model\\Task", $p["data"]); 
        return array(
			"taskId" => $task->id(),
		);
    }
    
    /**
     * Создает новую группу задач
     **/
    public function post_createGroup($p) {
        $task = service("ar")->create("\\Infuso\\Board\\Model\\Task", array(
            "text" => $p["text"],
            "group" => true,
		));
        return array(
			"taskId" => $task->id(),
		);
    }

    public function post_saveTask($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        $task->setData($p["data"]);
        app()->msg("Задача изменена");
    }
    
    /**
     * Сохраняет приорите списка задач. Используется при сортировке
     **/
    public function post_savePriority($p) {
        app()->suspendEvents();
        $n = 0;
        foreach($p["priority"] as $taskId) {
            $task = Model\Task::get($taskId);
            $task->data("priority", $n);
            $n++;
        }
    }
    
    public function post_timeInputContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/time-input-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }
    
    public function post_revisionDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/revision-dlg-ajax")
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
     * Отменяет задачу
     **/
    public function post_cancelTask($p) {

        $task = Model\Task::get($p["taskId"]);
        $time = $p["time"];

        if(!\user::active()->checkAccess("board/cancelTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\TaskStatus::STATUS_CANCELLED);
        $task->log(array(
            "text" => $p["comment"],
            "time" => $time,
            "type" => Model\Log::TYPE_TASK_CANCELLED,
        ));

        return true;
    }
    
    /**
     * Отправляет задачу на доработку
     **/
    public function post_revisionTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!\user::active()->checkAccess("board/revisionTaskToBacklog",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\TaskStatus::STATUS_BACKLOG);
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_REVISED,
        ));

        return true;
    }
    
    /**
     * Задача выполнена
     **/
    public function post_doneTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!\user::active()->checkAccess("board/doneTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status", Model\taskStatus::STATUS_CHECKOUT);
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_DONE,
        ));
        
        $time = $p["time"];
        $time = array_map(function($item) {
            return $item * 3600;
        }, $p["time"]);
        $task->chargeTime($time);

        return true;
    }


}
