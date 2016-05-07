<?

namespace Infuso\Board\Handler;
use \Infuso\Core;

class Mailer implements Core\Handler { 

    /**
     * @handler = board/task/new-comment
     **/
    public static function onComment($event) {     
        $comment = $event->param("comment");    
        $task = $comment->task();
        $task->emailSubscribers(array(
			"code" => "board/task/new-comment",
			"type" => "text/html",
			"comment" => $comment->data("text"),
			"user-id" => $comment->user()->id(),
		 	"nick" => $comment->user()->nickName(),
			"userpic-16" => $comment->user()->userpic()->preview(16,16),
		));     
    }

    /**
     * @handler = board/task/done
     **/
    public static function onTaskCompleted($event) {     
        $params = [];
        
        //$params["type"] = "text/html";
        //$params["from"] = "NDRA-board";
        //$message = "Задача № " . $this->id() . " выполнена и требует проверки.<br/><br/>" . $this->text();
        //$params["message"] = $message;          
        //$subject = $this->project()->title().": Задача № ".$this->id().".";
        //$params["subject"] = $subject;
 //       $params["attachFiles"] = 1;
        
        $params["code"] = "board/task/done";

        // Планируемое время
        $params["timeScheduled"] = $this->timeScheduled();
        
        // Затраченное время
        $params["timeSpent"] = round($this->timeSpent() / 3600, 2);
        
		// Добавляем комментарии к задаче
        /*$txt = "";
        foreach($this->getlog() as $item) {
            $date = $item->pdata("created")->date()->text();
            $time = $item->pdata("created")->format("H:i");
            if($text = $item->text()) {
                $text = \util::str($text)->esc();
                $text = nl2br($text);
                $txt.= "<br/>".$date." ".$time." : ".$item->user()->title()." : ".$text;
            }
        }
        $params["comments"] = $txt;   */
        
        $user = $this->workflow()->desc("id")->one()->pdata("userId");
        $params["userName"] = $user->title(); 
    }

}
