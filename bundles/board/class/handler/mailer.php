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
        $user = $event->param("user");
        $root = app()->url()->scheme()."://".app()->url()->domain();
        
        $task->emailSubscribers(array(
            "code" => "board/task/done",
            "type" => "text/html",
            "timeScheduled" => $task->timeScheduled(),
            "timeSpent" => round($task->timeSpent() / 3600, 2), 
			"user-id" => $user->id(),
		 	"nick" => $user->nickName(),
			"userpic-16" => $root.$user->userpic()->preview(16,16),   
        ));

    }
    
    /**
     * @handler = board/task/revised
     **/
    public static function onTaskRevised($event) {     
        
        $task = $event->param("task");
        $user = $event->param("user");
        $root = app()->url()->scheme()."://".app()->url()->domain();
        
        $task->emailSubscribers(array(
            "code" => "board/task/revised",
            "type" => "text/html",
            "timeScheduled" => $task->timeScheduled(),
            "timeSpent" => round($task->timeSpent() / 3600, 2), 
			"user-id" => $user->id(),
		 	"nick" => $user->nickName(),
			"userpic-16" => $root.$user->userpic()->preview(16,16),
            "comment" => $event->param("comment"),   
        ));

    }
    
    /**
     * @handler = board/task/problem
     **/
    public static function onTaskProblem($event) {     
        
        $task = $event->param("task");
        $user = $event->param("user");
        $root = app()->url()->scheme()."://".app()->url()->domain();
        
        $task->emailSubscribers(array(
            "code" => "board/task/problem",
            "type" => "text/html",
            "timeScheduled" => $task->timeScheduled(),
            "timeSpent" => round($task->timeSpent() / 3600, 2), 
			"user-id" => $user->id(),
		 	"nick" => $user->nickName(),
			"userpic-16" => $root.$user->userpic()->preview(16,16),
            "comment" => $event->param("comment"),
        ));

    }

}
