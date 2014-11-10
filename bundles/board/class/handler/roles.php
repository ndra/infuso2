<? 

namespace Infuso\Board\Handler;
use \Infuso\Core;
use \user_operation;
use \user_role;


class Roles implements Core\Handler { 
    
	/**
	 * @handler = infuso/deploy
	 **/
    public function init() {

        // Создаем роли
        $role = user_role::create("board/worker");
        $role->data("title","Пользователь доски");
        
        $role = user_role::create("board/manager");
        $role->data("title","Менеджер доски");
        
        $role = user_role::create("board/client");
        $role->data("title","Клиент доски");
        
        // ---------------------------------------------------------------------
        // Общие операции
        
        user_operation::create("board/showInterface", "Просмотр интерфейса доски")
            ->appendTo("board/worker")
            ->appendTo("board/manager")
            ->appendTo("board/client");
            
        // ---------------------------------------------------------------------
        // Задачи
        
        user_operation::create("board/showTaskList", "Просмотр списка задач")
            ->appendTo("board/worker")
            ->appendTo("board/manager")
            ->appendTo("board/client");
            
		user_operation::create("board/viewTask", "Просмотр задачи")
            ->appendTo("board/viewAllTasks")
            ->appendTo("board/viewTaskByAccess");
            
		user_operation::create("board/viewAllTasks", "Просмотр всех задач")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/viewTasksByAccess", "Возможность просмотра задач на основе доступа")
            ->appendTo("board/client");
            
		user_operation::create("board/viewTaskByAccess", "Просмотр задачи на основе доступа")
            ->appendTo("board/viewTasksByAccess")
            ->addBusinessRule('return !\\infuso\\board\\model\\task::all()->visible()->eq("id", $task->id())->void();');

		user_operation::create("board/editTask", "Редактирование задачи")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/takeTask", "Взять задачу")
		    ->addBusinessRule('if(!app()->user()->exists()) $this->error("Нельзя взять задачу без пользователя"); ')
			->addBusinessRule('return true;')
            ->appendTo("board/worker");
            
		user_operation::create("board/doneTask", "Выполнить задачу")
            ->appendTo("board/worker");
            
        //----------------------------------------------------------------------
        // Проекты
        
        user_operation::create("board/viewAllProjects", "Просмотр полного списка проектов")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
        user_operation::create("board/viewProjectsByAccess", "Просмотр проектов, к которым предоставлен доступ")
            ->appendTo("board/client");
            
        //----------------------------------------------------------------------
        // Доступ
        
        user_operation::create("board/manageAccess", "Управление доступом")
            ->appendTo("board/manager");
        
    }
    
}
