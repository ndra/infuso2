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
        $role->data("title","Доска / исполнитель");
        $role->data("superadmin", false);
        
        $role = user_role::create("board/manager");
        $role->data("title","Доска / менеджер");
        $role->data("superadmin", false);
        
        $role = user_role::create("board/client");
        $role->data("title","Доска / клиент");
        $role->data("superadmin", false);
        
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
            
		user_operation::create("board/editTask", "Редактирование задачи")
            ->appendTo("board/editAnyTask")
            ->appendTo("board/editTaskByAccess");
            
		user_operation::create("board/editAnyTask", "Редактирование любой задачи")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/editTaskByAccess", "Редактирование задачи на основе доступа")
            ->addBusinessRule('return !\\infuso\\board\\model\\task::all()->visible()->eq("id", $task->id())->void();')
            ->appendTo("board/client");

		user_operation::create("board/viewTask", "Просмотр задачи")
            ->appendTo("board/editTask");
            
		user_operation::create("board/takeTask", "Взять задачу")
		    ->addBusinessRule('if(!app()->user()->exists()) $this->error("Нельзя взять задачу без пользователя"); ')
			->addBusinessRule('return true;')
            ->appendTo("board/worker");
            
		user_operation::create("board/doneTask", "Выполнить задачу")
            ->appendTo("board/worker");
            
		user_operation::create("board/completeTask", "Проверить задачу")
            ->appendTo("board/editTaskByAccess")
            ->appendTo("board/manager");
            
		user_operation::create("board/stopTask", "Остановить задачу")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/pauseTask", "Поставить задачу на паузу")
            ->appendTo("board/worker");
            
		user_operation::create("board/showBacklog", "Показать бэклог")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/writeToBacklog", "Запись в бэклог")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/createGroup", "Создать группу")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
        //----------------------------------------------------------------------
        // Управление проектами
        
        user_operation::create("board/viewAllProjects", "Просмотр полного списка проектов")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
        user_operation::create("board/viewProjectsByAccess", "Просмотр проектов, к которым предоставлен доступ")
            ->appendTo("board/client");
            
       user_operation::create("board/editProject", "Редактирование проекта")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
        //----------------------------------------------------------------------
        // Управление доступом
        
        user_operation::create("board/manageAccess", "Управление доступом")
            ->appendTo("board/manager");
            
        //----------------------------------------------------------------------
        // Отчеты

        user_operation::create("board/showReportUsers", "Просмотр отчета по пользователям")
            ->appendTo("board/manager")
            ->appendTo("board/client")
			->appendTo("board/worker");
            
        user_operation::create("board/showReportProjects", "Просмотр отчета по проектам")
            ->appendTo("board/manager")
            ->appendTo("board/worker")
            ->appendTo("board/client");
        
    }
    
}
