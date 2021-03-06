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
        

        $group = new PseudoGroup($p["group"]);
        $group->setQuery($p["query"]);
        $group->setPage($p["page"]);

        $html = app()->tm("/board/widget/task-list/ajax")
            ->param("group", $group)
            ->getContentForAjax();

        return array(
            "html" => $html,
            "pages" => $group->pages()
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
        
        $html = app()->tm($task->data("group") ? "/board/task/content-group" : "/board/task/content-task")
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
        if($p["cloneTask"]) {
            $task = \Infuso\Board\Model\Task::get($p["cloneTask"]);
            $data = array(
                "projectId" => $task->data("projectId"),
                "parent" => $task->data("parent"),
            );                
        } else {
            $data = $p["data"];
        }        
        $data["status"] = Model\Task::STATUS_DRAFT;
        $task = service("ar")->create("\\Infuso\\Board\\Model\\Task", $data);             
        return array(
			"taskId" => $task->id(),            
		);
    }
    
    /**
     * Создает новую группу задач
     **/
    public function post_createGroup($p) {
    
        if(!app()->user()->checkAccess("board/createGroup")) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }
    
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

    /**
     * Сохраняет задачу
     **/         
    public function post_saveTask($p) {
    
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
    
        if(!app()->user()->checkAccess("board/editTask", array("task" => $task))) {
            app()->msg(app()->user()->errorText(),1); 
            return;  
        }
        
        $task->setData($p["data"]);
        
        if($task->data("status") == Model\Task::STATUS_DRAFT) { 
            if(app()->user()->checkAccess("board/writeToBacklog")) {
                $task->data("status", Model\Task::STATUS_BACKLOG);
            } else {
                $task->data("status", Model\Task::STATUS_REQUEST);
            }
            $task->sentToBeginning();
        }
        
        app()->msg("Задача изменена");
    }
    
    /**
     * Сохраняет приоритет списка задач.
     * Используется при сортировке
     **/
    public function post_savePriority($p) {     
   
        $n = 0;
        foreach($p["priority"] as $taskId) {
            $task = Model\Task::get($taskId);
            $task->data("priority", $n);
            $n++;
        }
        app()->msg("Сортировка изменена");
    }
    
    /**
     * Возвращает контент диалога закрытия задачи
     **/
    public function post_doneDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/done-dlg-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }
    
	/**
     * Возвращает контент диалога остановки задачи
     **/
    public function post_stopDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/stop-dlg-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }
    
 	/**
     * Возвращает контент диалога чтобы вернуть задачу
     **/
    public function post_revisionDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/revision-dlg-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }
    
 	/**
     * Возвращает контент диалога оповещения о проблеме
     **/
    public function post_problemDlgContent($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        return app()->tm()
            ->template("/board/shared/task-tools/problem-dlg-ajax")
            ->param("task", $task)
            ->getContentForAjax();
    }

    /**
     * Взять задачу
     **/
    public function post_takeTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!app()->user()->checkAccess("board/takeTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(),1);
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
        if(!app()->user()->checkAccess("board/pauseTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }

        $task->pause(app()->user());

    }

    /**
     * Положить задачу обратно
     **/
    public function post_stopTask($p) {

        $task = Model\Task::get($p["taskId"]);
        $time = $p["time"];

        if(!app()->user()->checkAccess("board/stopTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(), 1);
            return;
        }
        
        $time = $p["time"];
        $time = array_map(function($item) {
            return $item * 3600;
        }, $p["time"]);
        $task->chargeTime($time);     

        $task->data("status", app()->user()->checkAccess("board/writeToBacklog") ? 
            Model\Task::STATUS_BACKLOG : Model\Task::STATUS_REQUEST);
            
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

        if(!app()->user()->checkAccess("board/editTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(),1);
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

        if(!app()->user()->checkAccess("board/completeTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }

        $task->data("status", Model\Task::STATUS_COMPLETED);
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_CHECKED,
        ));

        return true;
    }
    
    /**
     * Отправляет задачу на доработку
     **/
    public function post_revisionTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!app()->user()->checkAccess("board/editTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }

        $task->data("status", app()->user()->checkAccess("board/writeToBacklog") ? 
            Model\Task::STATUS_BACKLOG : Model\Task::STATUS_REQUEST);
            
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_REVISED,
        ));
        
        app()->fire("board/task/revised", array(
            "task" => $task,
            "comment" => $p["comment"],
            "user" => app()->user(),
        ));

        return true;
    }
    
    /**
     * Оповещает о проблемах в задаче
     **/
    public function post_problemTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!app()->user()->checkAccess("board/editTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }

        $task->data("status", Model\Task::STATUS_PROBLEM);
            
        $task->log(array(
            "text" => $p["comment"],
            "type" => Model\Log::TYPE_TASK_PROBLEM,
        ));
        
        app()->fire("board/task/problem", array(
            "task" => $task,
            "comment" => $p["comment"],
            "user" => app()->user(),
        ));

        return true;
    }
    
    /**
     * Задача выполнена
     **/
    public function post_doneTask($p) {

        $task = Model\Task::get($p["taskId"]);

        if(!app()->user()->checkAccess("board/doneTask",array(
            "task" => $task,
        ))) {
            app()->msg(app()->user()->errorText(), 1);
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
        
        app()->fire("board/task/done", array(
            "task" => $task,
            "comment" => $p["comment"],
            "user" => app()->user(),
        ));

        return true;
    }


}
