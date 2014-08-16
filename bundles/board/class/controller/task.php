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
    
        if(!app()->user()->checkAccess("board/showTaskList")) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }

        $limit = 40; 
        
        // Полный список задач
        $tasks = Model\Task::all()->visible()->limit($limit);
        
        switch($p["status"]) {
        
            default:
        		$tasks->eq("status", $p["status"]);
        		$tasks->asc("priority");
        		break;
        		
			case "check":
			    $tasks->desc("changed");
        		$tasks->eq("status", array(
					Model\Task::STATUS_CHECKOUT,
					Model\Task::STATUS_COMPLETED,
					Model\Task::STATUS_CANCELLED,
				));
        		break;
        		
        }
            
        // Учитываем поиск
        if($search = trim($p["search"])) {
            $tasks->search($search);
        }

		if($groupId = $p["groupId"]) {
		    $tasks->eq("parent", $groupId);
		} else {
            $tasks->eq("parent", 0);
        }

        $tasks->page($p["page"]);
        
        $html = app()->tm("/board/widget/task-list/ajax")
            ->param("tasks", $tasks)
            ->param("status", $p["status"])
			->param("group", Model\Task::get($p["groupId"]))
            ->getContentForAjax();
            
        $title = app()->tm("/board/widget/task-list/ajax-title")
            ->param("tasks", $tasks)
            ->param("status", $p["status"])
			->param("group", Model\Task::get($p["groupId"]))
            ->getContentForAjax();
        
        return array(
            "html" => $html,
            "title" => $title,
            "pages" => $tasks->pages(),
        );
                  
    }

    /**
     * Возвращает html формы редактирования задачи.
     * Используется в диалоге, который открывается если кликнуть на карточку задачи.
     **/
    public function post_getTask($p) {
    
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        
        if(!app()->user()->checkAccess("board/viewTask", array("task" => $task))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }
        
        $html = app()->tm("/board/task/content")
            ->param("task", $task)
            ->getContentForAjax();
        return array(
			"html" => $html,
			"taskURL" => $task->url(),
		);
    }
    
    /**
     * Возвращает контент окна создания задачи
     **/
    public function post_newTaskWindow($p) {
        $html = app()
			->tm("/board/task-new")
			->param("group", Model\Task::get($p["groupId"]))
			->getContentForAjax();
        return array(
			"html" => $html,
		);
    }
    
    /**
     * Создает новую задачу
     **/         
    public function post_newTask($p) {     
    
        $p["data"]["status"] = Model\Task::STATUS_DRAFT;
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
            "parent" => $p["parent"],
            "status" => Model\Task::STATUS_BACKLOG,
		));
    
        $task->sentToBeginning();    
        
        return array(
			"taskId" => $task->id(),
		);
    }

    public function post_saveTask($p) {
    
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        $task->setData($p["data"]);
        
        if($task->data("status") == Model\Task::STATUS_DRAFT) {
            $task->data("status", Model\Task::STATUS_BACKLOG);
            $task->sentToBeginning();
        }
        
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
    
    public function post_doneDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/done-dlg-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }
    
    public function post_stopDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/stop-dlg-ajax")
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
        
        $time = $p["time"];
        $time = array_map(function($item) {
            return $item * 3600;
        }, $p["time"]);
        $task->chargeTime($time);

        $task->data("status",Model\Task::STATUS_BACKLOG);
        $task->log(array(
            "text" => $p["comment"],
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

        if(!\user::active()->checkAccess("board/editTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\Task::STATUS_CANCELLED);
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_CANCELLED,
        ));

        return true;
    }
    
    /**
     * Задача выполнена
     **/
    public function post_completeTask($p) {

        $task = Model\Task::get($p["taskId"]);
        $time = $p["time"];

        if(!\user::active()->checkAccess("board/completeTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\Task::STATUS_COMPLETED);
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_COMPLETED,
        ));

        return true;
    }
    
    /**
     * Отправляет задачу на доработку
     **/
    public function post_revisionTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!\user::active()->checkAccess("board/editTask",array(
            "task" => $task,
        ))) {
            app()->msg(\user::active()->errorText(),1);
            return;
        }

        $task->data("status",Model\Task::STATUS_BACKLOG);
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

        $task->data("status", Model\Task::STATUS_CHECKOUT);
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
