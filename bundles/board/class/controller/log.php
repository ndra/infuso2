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
    
    public function post_content($p) {
    
        $task = Model\Task::get($p["taskId"]);
        return app()->tmp()->template("/board/shared/comments/ajax", array(
            "task" => $task,
        ))->getContentForAjax();
    
    }
        
}
