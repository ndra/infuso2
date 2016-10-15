<?

namespace Infuso\Cms\Task;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель задачи
 **/
class Task extends ActiveRecord\Record implements Core\Handler {

	public static function model() {     	
		return array (
			'name' => 'reflex_task',
			'fields' => array (
				array (
					'name' => 'id',
					'type' => 'id',
				), array (
					'name' => 'class',
                    "label" => "Класс",
					'type' => 'textfield',
					'editable' => '1',
				), array (
					'name' => 'method',
                    "label" => "Метод",
					'type' => 'textfield',
					'editable' => '1',
				), array (
					'name' => 'params',
					'type' => 'array',
					'editable' => '1',
					'label' => 'Параметры',
				), array (
					'name' => 'internalParams',
					'type' => 'array',
					'editable' => '1',
					'label' => 'Дополнительные параметры',
                ), array (
					'name' => 'iterator',
					'type' => 'bigint',
					'editable' => '2',
					'label' => 'Итератор',
				), array (
					'name' => 'created',
					'type' => 'datetime',
					'editable' => '2',
					"default" => "now()",
                    "label" => "Создано",
				), array (
					'name' => 'called',
					'type' => 'datetime',
					'label' => 'Вызвано',
					'editable' => '2',
				), array (
					'name' => 'nextLaunch',
					'type' => 'datetime',
					'label' => 'Следующий запуск',
					'editable' => '2',
				), array (
					'name' => 'completed',
					'type' => 'checkbox',
					'editable' => '2',
					'label' => 'Выполнено',
				), array (
					'name' => 'counter',
					'type' => 'bigint',
					'editable' => '2',
					'label' => 'Выполнено раз',
				), array (
					'name' => 'lastErrorDate',
					'type' => 'datetime',
					'editable' => '2',
					'label' => 'Когда была последняя ошибка',
				), array (
					'name' => 'crontab',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Шаблон (в формате crontab)',
					'help' => "Минуты, часы, день месяца, месяц, день недели",
				), array (
					'name' => 'randomize',
					'type' => 'bigint',
					'label' => 'Рандомизировать (добавляет указанное количество минут ко времени следующего запуска)',
                    'editable' => true,
				), array (
					'name' => 'origin',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Источник',
				),  array (
					'name' => 'title',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Название',
                    
				),
			),
		);
	}
	
    public function beforeCreate() {
        $this->updateNextLaunchTime();
    }

    public function beforeStore() {
        if($this->field("crontab")->changed()) {
            $this->updateNextLaunchTime();
        }
    }

    /**
     * Возвращает коллекцию задач
     **/
    public static function all() {
        return service("ar")->collection(get_class())->desc("nextLaunch",true);
    }

    /**
     * Возвращает задачу по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }

	/**
     * Возвращает вызываемый метод
     **/
    public function method() {
        return $this->data("method");
    }
    
    /**
     * Возвращает вызываемый класс
     **/
    public function className() {
        return $this->data("class");
    }

	/**
     * Возвращает параметры вызываемого метода
     **/
    public function methodParams() {
        $params = $this->pdata("params");
        if(!is_array($params)) {
            $params = array();
        }
        return $params;
    }
    
    public function extra($key = null, $val = null) {
        if(func_num_args() == 0) {
            return $thius->pdata("internalParams");
        } elseif (func_num_args() == 1) {
            return $this->pdata("internalParams")[$key];
        } elseif (func_num_args() == 2) {
            $data = $this->pdata("internalParams");
            $data[$key] = $val;
            $this->data("internalParams", $data);
        }
    }

    /**
     * Обновляет время следующего запуска
     **/
    public function updateNextLaunchTime() {

		// Таймстэмп
		if(preg_match("/^\d+$/",$this->data("crontab"))) {
            $this->data("nextLaunch",$this->data("crontab"));
            
        // Mysql Date format
        } elseif(preg_match("/\d{4}-\d{2}-\d{2}\s(\d{2}\:\d{2}\:\d{2})?/",$this->data("crontab"))) {
            $this->data("nextLaunch",$this->data("crontab"));
            
        // Пустая строка
        } elseif(trim($this->data("crontab"))=="") {
            $this->data("nextLaunch", \util::now());
            
		// Прочее - кронтаб
        } else {
            $time = \reflex_task_crontab::nextDate($this->data("crontab"));
            $this->data("nextLaunch",$time);
        }
        
        $min = rand(0, $this->data("randomize") * 60);
        $this->data("nextLaunch", $this->pdata("nextLaunch")->shift($min));
    }

    /**
     * Одноразовая ли задача
     **/
    public function oneTime() {
    
        // Если время выполнения задано как таймстэмп - задача одноразовая
        if(preg_match("/^\d+$/",$this->data("crontab"))) {
            return true;
        }

		// MySQL-формат - одноразовая задача
        if(preg_match("/\d{4}-\d{2}-\d{2}\s(\d{2}\:\d{2}\:\d{2})?/",$this->data("crontab"))) {
            return true;
        }

        return false;

    }

	/**
	 * Выполняет данную задачу
	 **/
    public function exec() {

        $this->updateNextLaunchTime();
    
        try {
        
			$this->data("called", \util::now());

            if($this->oneTime()) {
                $this->data("completed",true);
            }

            $this->store();

	        $method = $this->method();
	        $class = $this->className();
	        $params = $this->methodParams();
	        
	        $callback = array($class, $method);

	        if(!is_callable($callback)) {
	            throw new \Exception("{$callback[0]}::{$callback[1]} is not a callback");
	            return;
	        }
	        
	        call_user_func($callback, $params, $this);

			$this->data("counter",$this->data("counter")+1);
	        
		} catch (\Exception $ex) {

		    $this->data("lastErrorDate", \util::now());
			$this->plugin("log")->log(array(
                "text" => "Exception: ".$ex->getMessage(),
                "type" => "error",
            ));
		    
		}
	        
    }
    
    public function recordTitle() {
        
        $params = $this->pdata("params");
        
        if($title = $this->data("title")) {
            return $title;
        }
    
        if(strtolower($this->data("class")) == "infuso\\cms\\task\\reflex") {
            $title = "DB task ".$params["class"]."::".$params["method"];
            if($params["query"]) {
                $title.= " ({$params['query']})";
            }
            return $title;
        }
    
        return $this->data("class")."::".$this->data("method");
    }

}
