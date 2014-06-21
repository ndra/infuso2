<?

namespace Infuso\Cms\Utils\Heartbeat;
use Infuso\Core;

/**
 * Событие пульсометра
 **/  
class Event extends Core\Event {

	const TYPE_ERROR = 1;
	const TYPE_WARNING = 2;
	const TYPE_MESSAGE = 3;

	private $messages = array();
	
    /**
     * Добавляет сообщение об ошибке
     **/         
	public function error($message) {
	    $this->messages[] = array(
	        "class" => $this->handlerClass(),
	        "method" => $this->handlerMethod(),
	        "type" => self::TYPE_ERROR,
	        "message" => $message,
		);
	}
	
    /**
     * Добавляет предупреждение
     **/
	public function warning($message) {
	    $this->messages[] = array(
			"class" => $this->handlerClass(),
	        "method" => $this->handlerMethod(),
	        "type" => self::TYPE_WARNING,
	        "message" => $message,
		);
	}
	
    /**
     * Добавляет сообщение
     **/
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
