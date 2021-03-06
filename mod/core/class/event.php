<?

namespace Infuso\Core;

/**
 * Класс, описывающий событие
 **/
class Event extends component {

    private static $firedEvents = array();

    private $name = null;
    
    private $handlerClass = null;
    
    private $handlerMethod = null;

    public function __construct($name, $params = array()) {
        $this->name = $name;
        $this->params($params);
    }

    /**
     * Возвращает имя события
     **/
    public function name() {
        return $this->name;
    }
    
    /**
     * Возвращает массив классов, которые могут реагировать на данное событие
     **/
    public final function handlers() {
        $handlers = service("classmap")->classmap("handlers");
        $handlers = $handlers[$this->name()];
        if(!$handlers) {
            $handlers = array();
        }
        return $handlers;
    }

    /**
     * Возвращает кэллбэков для данного события
     **/
    public final function callbacks() {
        $callbacks = array();
        foreach($this->handlers() as $handler) {
            $callbacks[] = explode("::",$handler);
        }
        return $callbacks;
    }

    /**
     * Вызывает данное событие и запускает обработчики
     **/
    public final function fire() {
    
        $n = 0;
        while($this->firePartial($n)) {
            $n++;
        }
        
        // Складываем события, которые предназначаются клиенту в массив
        if($this->param("deliverToClient")) {
        	self::$firedEvents[] = $this;
        }
    }

    /**
     * Метод разработан для вызова одного события в несколько подходов
     **/
    public final function firePartial($from) {
    
        if($this->stopped()) {
            return false;
        }
    
        $callbacks = $this->callbacks();
        $callback = $callbacks[$from];
        
        if($callback) {
        
            profiler::beginOperation("event", $this->name(), $callback[0]."::".$callback[1]);
            
            // Сохраняем информацию о классе и методе, которые обрабатываются в данный момент
            // Это используется в heartbeat
            $this->handlerClass = $callback[0];
            $this->handlerMethod = $callback[1];
            
            call_user_func($callback, $this);
            
            $this->handlerClass = null;
            $this->handlerMethod = null;
            
            profiler::endOperation();
            
            return true;
        }

        return false;
    }
    
    /**
     * Возвращает класс, который обрабатывает событие в данный момент
     **/
    public final function handlerClass() {
        return $this->handlerClass;
    }
    
    /**
     * Возвращает метод, который обрабатывает событие в данный момент
     **/
	public function handlerMethod() {
	    return $this->handlerMethod;
    }
    
    /**
     * Останавливает обработку эвента. Другие события не выполянтся
     **/
    public function stop() {
        $this->param("*stopped",true);
    }
    
    /**
     * Возвращает true если событие остановлено
     **/
    public function stopped() {
        return !!$this->param("*stopped");
    }

    /**
     * Возвращает все события, вызванные в текущем запуске скрипта
     * @return array
     **/
    public static function all() {
        return self::$firedEvents;
    }
    
    public static function clearFiredEvents() {
        self::$firedEvents = array();
    }

}
