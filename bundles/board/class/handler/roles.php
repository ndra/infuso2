<? 

namespace Infuso\Board\Handler;
use \Infuso\Core;
use \user_operation;
use \user_role;


class Roles implements Core\Handler { 
    
	/**
	 * @handler = infusoDeploy
	 **/
    public function init() {

        // Создаем роли
        $role = user_role::create("board/worker");
        $role->data("title","Пользователь доски");
        
        $role = user_role::create("board/manager");
        $role->data("title","Менеджер доски");
        
        $role = user_role::create("board/client");
        $role->data("title","Клиент доски");
        
        user_operation::create("board/showTaskList", "Просмотр списка задач")
            ->appendTo("board/worker")
            ->appendTo("board/manager")
            ->appendTo("board/client");
            
		user_operation::create("board/viewTask", "Просмотр задачи")
            ->appendTo("board/worker")
            ->appendTo("board/manager");

		user_operation::create("board/editTask", "Редактирование задачи")
            ->appendTo("board/worker")
            ->appendTo("board/manager");
            
		user_operation::create("board/takeTask", "Взять задачу")
            ->appendTo("board/worker");
            
		user_operation::create("board/doneTask", "Выполнить задачу")
            ->appendTo("board/worker");
        
    }
    
}
