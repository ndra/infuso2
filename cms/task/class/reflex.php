<?
namespace Infuso\Cms\Task;

/**
 * Класс для задач-итераторов рефлекса
 **/
class Reflex {

    public static function add($p) {
       
		$task = service("task")->add(array(
            "class" => get_class(),
            "method" => "execReflex",
            "params" => array(
                "class" => $p["class"],
                "method" => $p["method"],
                "query" => $p["query"],
                "params" => $p["params"],
            ),
        ));

        return $task;

    }

	/**
	 * Статический метод для задач-рефлексов
	 **/
    public static function execReflex($p, $task) {

		$query = 1;
		
        if($q = trim($p["query"])) {
        
	        if(($q*1).""==$q."") {
	            $q = " `id`='{$q}' ";
			}
			
			$query = $q;
        }
        
        $item = service("ar")->collection($p["class"])
            ->asc("id")
            ->gt("id",$task->data("iterator"))
            ->where($query)
            ->one();
            
        if(!$item->exists()) {
            $task->data("completed",true);
			
			/**
			 * создаем событие завершения задачи
			 **/
			app()->fire("infuso/task/completed", array(
                "taskId" => $task->id(),
                "deliverToClient" => true,
    		));
			
            $task->store();
            return;
        }

        $task->data("iterator",$item->id());
        $task->store();

        $method = $p["method"];
        $params = $p["params"];
        
        $item->$method($params);

    }

}
