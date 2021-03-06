<?

namespace Infuso\Template;
use Infuso\Core;
use Infuso\Core\Profiler;

class Conveyor extends Core\Component {

    private $items = array();
    private $delayed = array();
    private $hashes = array();
    private static $delayedFunctionResult = array();
    
    public function initialParams() {
        return array(
            "preventCaching" => false,
        );
    }
    
    public function dataWrappers() {
        return array(
            "preventCaching" => "mixed",
        );
    }

    /**
     * Добавляет элемент в конвеер
     * $params = array(
     *     "t" => type,
     *     "c" => path or content,
     *     "p" => priority,
     *     "n" => id number
     * );
     **/
    public function add($params) {

        // Вычисляем хэш добавляемого элемента
        // Если хэш уже есть в списке хэшей, не добавляем второй раз
        $hash = md5($params["t"].":".$params["c"]);
        if($this->hashes[$hash]) {
            return;
        }
        
        $this->hashes[$hash] = true;
        
        $params["n"] = sizeof($this->items);
        if(!$params["p"]) {
            unset($params["p"]);
        }
            
        $this->items[] = $params;
    }
    
    /**
     * Добавляет отложенную функцию в конвеер
     * Возвращает id отложенной функии (оно же маркер, который вставляется в текст
     * и позже заменяется на результат выполнения функции)
     **/
    public function addDelayedFunction($delayedFunctionParams) {
    
        if(!$delayedFunctionParams["key"]) {
            $delayedFunctionParams["key"] = \util::id();
        }

        $this->delayed[] = $delayedFunctionParams;

        return $delayedFunctionParams["key"];
    }

    public function getDelayedFunction() {

        usort($this->delayed,function($a,$b) {
            return $a["priority"] - $b["priority"];
        });

        return array_shift($this->delayed);
    }
    
    /**
     * Статический служебный метод для preg_replace_callback
     * Заменить маркер функции на ее выполненное содержимое
     **/
    private static function replaceDelayedFn($matches) {

        $key = "/" . preg_quote($matches[0], '/') . "/";

        $ret = self::$delayedFunctionResult[$key];
        
        unset(self::$delayedFunctionResult[$key]);

        return $ret;
    }

    /**
     * Заменяет маркеры отложенных функций в строке $str на результат выполнения этих функций
     * Если отложенные функции вызывают другие отложенные функции, то метод
     * выполнит замену еще раз, и так до тех пор пока функции не перестанут добавляться (или пока не сработает ограничение на количество итераций)
     **/
    public function processDelayed($str) {
    
        profiler::beginOperation("tmp","processDelayed","");
        profiler::setVariable("contentSize",mb_strlen($str,"utf-8"));

        while($delayed = $this->getDelayedFunction()) {

            $arguments = $delayed["arguments"];
            if(!$arguments) {
                $arguments = array();
            }

            // Выполняем отложенную функцию и записываем результат

            ob_start();

            profiler::beginOperation("tmp","execDelayed",$delayed["class"]."::".$delayed["method"]."()");

            call_user_func_array(array(
                $delayed["class"],
                $delayed["method"]
            ),$arguments);
            profiler::endOperation();

            self::$delayedFunctionResult["/".$delayed["key"]."/"] = ob_get_clean();

        }
        
        // Обрабатываем текст, заменяе маркеры отложенных функций на результат их выполнения.
        $count = 0;
        do {
            $str = preg_replace_callback(array_keys(self::$delayedFunctionResult), array(self, "replaceDelayedFn"), $str, -1, $count);
        } while ($count > 0);

        profiler::endOperation();
        return $str;
        
    }

    /**
     * Возвращаем массив элементов из конвеера в сериализованном виде
     * Используется для кэширования 
     **/
    public function serialize() {
        return serialize(array(
            "items" => $this->items,
            "delayed" => $this->delayed,
        ));
    }
    
    /**
     * Восстанавливает конвейер из сериализованного состояния
     **/
    public static function unserialize($data) {
    
        $data = unserialize($data);
        
        $conveyor = new self();
        
        if($data["items"]) {
            foreach($data["items"] as $item) {
                $conveyor->add($item);
              }
          }
          
          if($data["delayed"]) {
            foreach($data["delayed"] as $delayed) {
                $conveyor->addDelayedFunction($delayed);
            }
        }
        
        return $conveyor;
    
    }
    
    /**
     * Объеденяет данный конвеер с переданным конвеером
     **/
    public function mergeWith($conveyor) {
    
        foreach($conveyor->items as $item) {
            $this->add($item);
        }
            
        foreach($conveyor->delayed as $d) {
            $this->addDelayedFunction($d);
        }
        
        if($conveyor->preventCaching()) {
            $this->preventCaching(true);
        }
    
    }
    
    /**
     * Сортируемт элементы конвеера
     **/
    private static function sortItems($a,$b) {
        // Сравниваем по приоритету
        if($d = $a["p"] - $b["p"]) {
            return $d;
        }
        // Если приоритеты равны, сравниваем по порядковому номеру
        return $a["n"] - $b["n"];
    }
    
    /**
     * Выполняет конвеер и генерирует данные для ajax
     * @todo добавить вывод одиночных css и js, подключать скрипты инлайном как и css
     **/
    public function getContentForAjax() {
    
        return $this->exec(array (
            "singlecss" => false,
            "packcss" => "inline",
            "singlejs" => false,
            "packjs" => "inline",
            "script" => true,
            "head" => false,
            "region" => null,
        ));
    }

    /**
     * Выполняет конвеер: объединяет все скрипты, стили, настройки
     * и генерирует содержимое тэга head
     **/
    public function exec($params = array()) {
    
        profiler::beginOperation("tmp", "execConveyor", null);
        
        $params = array_merge(array (
            "singlecss" => "link",
            "packcss" => "link",
            "singlejs" => "link",
            "packjs" => "link",
            "script" => true,
            "head" => true,
            "region" => null,
        ), $params);        

        $singleCss = array();
        $packCss = array();
        $singleJs = array();
        $packJs = array();
        $script = array();
        $heads = array();

        $items = $this->items;
        usort($items, array("self", "sortItems"));

        // Раскладываем элемнты конвеера по группам
        foreach($items as $item) {
        
            if($item["r"] != $params["region"]) {
                continue;
            }
                   
            switch($item["t"]) {
                case "sc":
                    $singleCss[] = $item["c"];
                    break;
                case "c":
                    $packCss[] = $item["c"];
                    break;
                case "sj":
                    $singleJs[] = $item["c"];
                    break;
                case "j":
                    $packJs[] = $item["c"];
                    break;
                case "h":
                    $heads[] = $item["c"];
                    break;
                case "s":
                    $script[] = $item["c"];
                    break;
            }
        }

        $head = "";
        
        $render = new Render();

        // Одиночные css
        switch($params["singlecss"]) {        
            case "link":
                foreach($singleCss as $item) {
                    $head.= "<link rel='stylesheet' type='text/css' href='{$item}' />\n";
                }
                break;
        }

        // Упакованные css
        switch($params["packcss"]) {   
            case "link":
                $packCss = $render->packIncludes($packCss, "css");
                if($packCss) {
                    $head.= "<link rel='stylesheet' type='text/css' href='{$packCss}' />\n";
                }
                break;
            case "inline":
                $packCss = $render->packIncludes($packCss, "css");
                if($packCss) {
        			$head.= "<style type='text/css'>";
        			$head.= Core\File::get($packCss)->data();
        			$head.= "</style>";
                }
                break;
        }

        // Одиночные js
        switch($params["singlejs"]) {        
            case "link":
                foreach($singleJs as $item) {
                    $head.= "<script type='text/javascript' src='{$item}'></script>\n";
                }
                break;
        }

        // Упакованные js
        switch($params["packjs"]) {        
            case "link":
                $packJs = $render->packIncludes($packJs, "js");
                if($packJs) {
                    $head.= "<script type='text/javascript' src='{$packJs}'></script>\n";
                }
                break;
            case "inline":
                $packJs = $render->packIncludes($packJs, "js");
                if($packJs) {
                    $head.= "<script type='text/javascript' src='$packJs'></script>\n";
                }
                break;
        }

        if($params["script"]) {        
            foreach($script as $item) {
                $head.= "<script type='text/javascript'>$item</script>\n";
            }
        }

        if($params["head"]) {    
            foreach($heads as $item) {
                $head.= "$item\n";
            }
        }
            
        Profiler::endOperation("tmp","execConveyor");

        return $head;
    }

}

