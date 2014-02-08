<?

namespace Infuso\Core;

class Defer {

    /**
     * Статический массив для хранения списка отложенных функций
     **/
    private static $defer = array();

    /**
     * Ставит задачу отложенного вызова метода $method
     **/
    public function add($component, $method) {

        if(!self::$defer[$component->getComponentID()]) {
            self::$defer[$component->getComponentID()] = array(
                "component" => $component,
                "methods" => array(),
            );
        }

        self::$defer[$component->getComponentID()]["methods"][$method] = true;

    }

    /**
     * Выполняет все отложенные функции
     * Вы не должны вызывать этот метод напрямую, его вызывает система
     **/
    public static function callDeferedFunctions() {

        $n = 0;

        while(sizeof(self::$defer)) {

            $defer = self::$defer;
            self::$defer = array();

            foreach($defer as $component) {
                foreach($component["methods"] as $method => $none) {
                    $component["component"]->$method();
                }
            }

            $n++;

            if($n>500) {
                throw new Exception("Defered function recursion");
            }
        }
    }

}
