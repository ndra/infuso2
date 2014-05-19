<?

namespace Infuso\Core\Message;
use \Infuso\Core;

/**
 * Служба пользовательских сообщений
 **/ 
class Service extends Core\Service {

    public function serviceName() {
        return "msg";
    }

    /**
     * Отправляет пользовательское сообщение
     **/
    public function msg($message, $error = false) { 
    
        $message = self::toString($message);

        @session_start();
        
        if(!$_SESSION["log:messages"]) {
            $_SESSION["log:messages"] = array();
        }
            
        $key = sizeof($_SESSION["log:messages"])-1;
        
        if($_SESSION["log:messages"][$key]["text"]==$message && $session[$key]["error"]==$error) {
            $_SESSION["log:messages"][$key]["count"]++;
        } else {
            $_SESSION["log:messages"][] = array(
                'text' => $message,
                'error' => $error,
                "count" => 1,
            );
        }
    }

    /**
     * Очищает список сообщений
     **/
    public static function clear() {
        @session_start();
        $_SESSION["log:messages"] = array();
    }

    /**
     * Возвращает сообщения
     * Если параметр опущен или равен true, функция дополнительно очищает список сообщений.
     **/
    public static function messages($clear=true) {
        $msg = array();
        @session_start();
        if(!$_SESSION["log:messages"]) {
            $_SESSION["log:messages"] = array();
        }
        foreach($_SESSION["log:messages"] as $m) {
            $msg[] = new Message($m);
        }
        if($clear) {
            self::clear();
        }
        return $msg;
    }

    /**
     * Преобразует переданное занчение в строку
     **/         
    public function toString($a) {

        // Массив
        if(is_array($a)) {
            $a = var_export($a,1);
            $a = preg_replace("/\n/"," ",$a);
            return $a;
        }

        if(is_object($a)) {
            if(get_class($a)=="SimpleXMLElement") {
                return strtr(util::prettyPrintXML($a),array("\n"=>" "));
            }
        }

        // Скаляр или прочее
        return $a;
    }

}
