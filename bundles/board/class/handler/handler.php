<?

class board_handler implements \Infuso\Core\Handler {

    public function on_user_subscription_beforeMail($event) {
    
        app()->msg($event->param("subscriptionKey"));
    
        // Предотвращаем отправку писем о выполненных задачах самому себе
		if(preg_match("/^board\/project-(\d+)\/taskCompleted$/",$event->param("subscriptionKey"))) {
		    if($event->param("completedBy") == $event->param("userID")) {
		        $event->stop();
		    }
		}
    }

}
