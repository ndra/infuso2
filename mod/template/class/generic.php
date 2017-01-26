<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Базовый класс для шаблонов, виджетов в пр.
 **/
abstract class Generic extends Core\Component {

    public function __invoke() {
        $args = func_get_args();
        return call_user_func_array(array($this,"exec"),$args);
    }

    abstract public function exec();

    /**
     * Выполняет шаблон или виджет и возвращает результат ввиде строки
     **/
    public function rexec() {
        ob_start();
        $this->exec();
        return ob_get_clean();
    }

    public function delayed($priority = 0) {
        echo $this->delayedMarker($priority);
    }

    public function delayedMarker($priority = 0) {
    
        $params = $this->params();
        $params["*delayed"] = false;
    
        return \tmp_delayed::add(array(
            "class" => "infuso\\template\\generic",
            "method" => "execStatic",
            "priority" => $priority,
            "arguments" => array(
                get_class($this),  
                $params,              
            ),
        ));
    }
    
    public static function execStatic($class,$p) {
    
        $generic = new $class;
        $generic->params($p);
        $generic->exec();
    
    }

}
