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
					'name' => 'origin',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Источник',
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
        return \reflex::get(get_class())->desc("nextLaunch",true);
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
    public function methodParams(){
        $params = $this->pdata("params");
        if(!is_array($params)) {
            $params = array();
        }
        return $params;
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
	        $this->plugin("log")->log("Выполняем");
	        
		} catch (\Exception $ex) {

			app()->msg($ex->getMessage());
		    $this->data("lastErrorDate", \util::now());
			$this->plugin("log")->log("Exception: ".$ex->getMessage());
		    
		}
	        
    }

}
