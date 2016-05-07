<?

namespace Infuso\Board\Handler;
use \Infuso\Core;

class Mailer implements Core\Handler { 

    /**
     * @handler = board/task/new-comment
     **/
    public static function onComment($event) {   
    
        $root = app()->url()->scheme()."://".app()->url()->domain();
      
        $comment = $event->param("comment");    
        $task = $comment->task();
        $task->emailSubscribers(array(
			"code" => "board/task/new-comment",
			"type" => "text/html",
			"comment" => $comment->data("text"),
			"user-id" => $comment->user()->id(),
		 	"nick" => $comment->user()->nickName(),
			"userpic-16" => $root.$comment->user()->userpic()->preview(16,16),
		));     
    }

    /**
     * @handler = board/task/done
     **/
    public static function onTaskCompleted($event) {     
        
        $task = $event->param("task");
        $user = $task->workflow()->desc("id")->one()->pdata("userId");
        
        $task->emailSubscribers(array(
            "code" => "board/task/done",
            "timeScheduled" => $task->timeScheduled(),
            "timeSpent" => round($task->timeSpent() / 3600, 2), 
			"user-id" => $user->id(),
		 	"nick" => $user->nickName(),
			"userpic-16" => $root.$user->userpic()->preview(16,16),
        ));         
         

    }

}
