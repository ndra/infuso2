<?

namespace Infuso\Cms\Task;
use Infuso\Core;

class Service extends Core\Service {

 
    public function defaultService() {
        return "task";
    }
    
    public function initialParams() {
        return array(
            "timeout" => 2,
        );
    } 
    
     /**
     * Возвращает список задач, которые уже могут быть выполнены
     **/
    public function tasksToLaunch() {
        return Task::all()
            ->leq("nextLaunch", \util::now())
            ->eq("completed",0);
    }
    

    /**
     * Добавляет новое задание очередь. Задание - это выполнение заданного метода заданной модели по крону.
     * Перебирается полная коллекция элементова можели или ее часть, если задано условие "query"
     * Если задание уже есть, повторного добавления не будет
     *
     * reflex_task::create(
     *    "class" => ..,
     *    "method" => ..,
     *    "query" => ..,
     *    "priority" => ..,
     *    "params" => ..,
     * )
     * @todo $params["params"] = mod::field("array")->prepareValue($params["params"])->value(); - какая-то хер, я не понимаю [Голиков]
     **/
    public static function add($params) {

        // Разруливаем олдскульный случай, когда параметры передавались не массивом а в аргументах

        if(is_array($params)) {
            $params = \util::a($params)->filter("class","query","method","params","crontab")->value();

        } else {

            $args = func_get_args();

            $params = array(
                "class" => $args[0],
                "method" => $args[2],
                "params" => $args[3] ? $args[3] : array(),
            );
        }

        // Разруливаем reflex-задачи

        $mode = "reflex";

        try {
	        $rmethod = new \ReflectionMethod($params["class"],$params["method"]);
	        if($rmethod->isStatic()) {
	            $mode = "static";
	        }
		} catch (\Exception $ex) {}

        if($mode == "reflex") {
            \Infuso\Cms\Task\Reflex::add($params);
            return;
        }

		// Если мы дошли до этого места, у нас обычная статическая задача

        if(!$params["class"]) {
            throw new Exception("Параметр <b>class</b> не указан");
        }

        if(!$params["method"]) {
            throw new Exception("Параметр <b>method</b> не указан");
        }

        $params["completed"] = 0;
        $params["params"] = Core\Model\Field::get("array")->prepareValue($params["params"]);

        $item = Task::all()
            ->eq($params)
            ->one();

		$params["origin"] = Handler::getOrigin();

        if(!$item->exists()) {
            $item = service("ar")->create(Task::inspector()->className(),$params);
        } else {
            if($params["origin"]) {
            	$item->data("origin",$params["origin"]);
            	$item->store();
            }
        }

    }
    
    /**
     * Выполняет одно задание
     **/
    public function execOne() {

        $tasks = $this->tasksToLaunch();
        $total = $tasks->count();

        if($total == 0) {
            return false;
        }

        // $n - хранится в кэше и увеличивается на 1 с каждым запуском крона
        $n = service("cache")->get("01h1b4yw6kbz2l9y6orj");
        if(!$n) {
            $n = 0;
        }

        // Выбираем задачу в зависимости от $n
        // Т.о. каждый на запуск крона задачи будут поочередно вызываны
        $task = $tasks->limit(1)->page($n%$total+1)->one();

        service("cache")->set("01h1b4yw6kbz2l9y6orj",$n+1);

        $task->exec();
        return true;
    }
    
    /**
     * Выполняет задачи
     * Ограничивается временем, указанном в настройках.
     **/
	public function runTasks() {
        $start = microtime(true);
        while(microtime(true) - $start < $this->param("timeout")) {
            if(!$this->execOne()) {
                break;
            }
            app()->fire("cleanup");
        }        
    }
    
}     
