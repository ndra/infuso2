<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Log extends Base {
    
    public function post_send($p) { 
        service("ar")->create(Model\Log::inspector()->className(), array(
            "taskId" => $p["taskId"],
            "text" => $p["text"],
        )); 
    }
    
    /**
     * Возвращает html-код комментариев и лога
     **/         
    public function post_content($p) {     
        $task = Model\Task::get($p["taskId"]);
        return app()->tm()->template("/board/shared/comments/ajax", array(
            "task" => $task,
        ))->getContentForAjax();       
    }
        
}
