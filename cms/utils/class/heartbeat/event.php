<?

namespace Infuso\Cms\Utils\Heartbeat;
use Infuso\Core;

class Event extends Core\Event {

	private $messages = array();
	
	const TYPE_ERROR = 1;
	const TYPE_WARNING = 2;
	const TYPE_MESSAGE = 3;

	public function error($message) {
	    $this->messages[] = array(
	        "class" => $this->handlerClass(),
	        "method" => $this->handlerMethod(),
	        "type" => self::TYPE_ERROR,
	        "message" => $message,
		);
	}
	
	public function warning() {
	    $this->messages[] = array(
			"class" => $this->handlerClass(),
	        "method" => $this->handlerMethod(),
	        "type" => self::TYPE_WARNING,
	        "message" => $message,
		);
	}
	
	public function message($message) {
	    $this->messages[] = array(
			"class" => $this->handlerClass(),
	        "method" => $this->handlerMethod(),
	        "type" => self::TYPE_MESSAGE,
	        "message" => $message,
		);
	}
	
	/**
	 * Возвращает список всех сообщений
	 **/
	public function getMessages() {
	    return $this->messages;
	}

}
