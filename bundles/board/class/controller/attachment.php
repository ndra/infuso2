<?

namespace Infuso\Board\Controller;
use Infuso\Board\Model;
use \Infuso\Core;

/**
 * Контроллер для операций с вложениями в задачи
 **/
class Attachment extends Core\Controller {

    public function postTest() {
        return \User::active()->exists();
    }

	/**
	 * Закачивает файл в задачу
	 **/
    public function post_upload($p) {
    
        $task = Model\Task::get($p["taskId"]);

        // Параметры задачи
        if(!app()->user()->checkAccess("board/editTask",array(
            "task" => $task
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }

        $file = $_FILES["file"];
        $path = $p["sessionHash"] ? "/log/".$p["sessionHash"] : "/";
        $task->storage()->setPath($path)->addUploaded($file["tmp_name"],$file["name"]);
		$task->updateUnique();
        
        app()->fire("board/task/attachments-changed", array(
            "taskId" => $task->id(),
            "deliverToClient" => true,
		));

    }
    
    /**
     * Удаляет файл из задачи
     **/
    public function post_delete($p) {
    
		$task = Model\Task::get($p["taskId"]);
		
        // Параметры задачи
        if(!app()->user()->checkAccess("board/editTask",array(
            "task" => $task
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }
		
        $task->storage()->delete($p["path"]);
        app()->fire("board/task/attachments-changed", array(
            "taskId" => $task->id(),
            "deliverToClient" => true,
		));
    }
    
    /**
     * Возвращает html списка прикрепленных файлов для страницы задачи.
     **/
    public function post_getAttachments($p) {
    
        $task = Model\Task::get($p["taskId"]);
        
        // Параметры задачи
        if(!app()->user()->checkAccess("board/viewTask",array(
            "task" => $task
        ))) {
            app()->msg(app()->user()->errorText(),1);
            return;
        }
        
        $html = app()->tm("/board/task/content/files/ajax")
            ->param("task", $task)
            ->getContentForAjax();
        return array(
			"html" => $html,
		);
    }

}
