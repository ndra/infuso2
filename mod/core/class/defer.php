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
    
        if(is_string($component)) {
            $id = $component;
        } elseif(is_object($component) && (is_a($component, "infuso\\core\\component"))) {
            $id = $component->getComponentID();
        } else {
            throw new \Exception("defer::add() bad parameter");
        }

        if(!self::$defer[$id]) {
            self::$defer[$id] = array(
                "component" => $component,
                "methods" => array(),
            );
        }

        self::$defer[$id]["methods"][$method] = true;

    }

    /**
     * Выполняет все отложенные функции
     * Вы не должны вызывать этот метод напрямую, его вызывает система
     **/
    public static function callDeferedFunctions() {

        $n = 0;

        app()->fire("infuso/defer");

        while(sizeof(self::$defer)) {

            $defer = self::$defer;
            self::$defer = array();

            foreach($defer as $component) {
                foreach($component["methods"] as $method => $none) {
                    call_user_func(array($component["component"], $method));
                }
            }

            $n++;

            if($n > 500) {
                throw new \Exception("Defered function recursion");
            }
        }
    }

}
