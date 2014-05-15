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
        if(!\user::active()->checkAccess("board/uploadFile",array(
            "task" => $task
        ))) {
            Core\Mod::msg(user::active()->errorText(),1);
            return;
        }

        $file = $_FILES["file"];
        $path = $p["sessionHash"] ? "/log/".$p["sessionHash"] : "/";
        $task->storage()->setPath($path)->addUploaded($file["tmp_name"],$file["name"]);
        $task->uploadFilesCount();

    }
    
    /**
     * Возвращает html списка прикрепленных файлов для страницы задачи.
     **/
    public function post_getAttachments($p) {
        $task = \Infuso\Board\Model\Task::get($p["taskId"]);
        $html = \tmp::get("/board/task/content/files/ajax")
            ->param("task", $task)
            ->getContentForAjax();
        return array(
			"html" => $html,
		);
    }

}
