<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class PseudoGroup extends Core\Component {

	private $id = null;

	public function __construct($id) {
	    $this->id = $id;
	}
	
	/**
	 * Возвращает id группы
	 **/
	public function id() {
	    return $this->id;
	}

	/**
	 * Возвращает массив задач в группе, видимых для пользователя
	 **/
	public function subgroups() {
		list($status, $id) = explode("/", $this->id);
		
		$ret = array();
		
		switch($status) {
		    case "request":
				if($id) {
				    $tasks = Model\Task::all()
				        ->visible()
				        ->eq("status", Model\Task::STATUS_REQUEST)
						->eq("projectId", $id);
				    foreach($tasks as $task) {
				        $ret[] = new self("task/".$task->id());
				    }
			    } else {
				    $projects = Model\Project::all()
				        ->visible()
				        ->join("Infuso\Board\Model\Access", "`Infuso\Board\Model\Access`.`projectId` = `Infuso\Board\Model\Project`.`id`");
				    foreach($projects as $project) {
				        $ret[] = new self("request/".$project->id());
				    }
			    }
			    break;
		    case "backlog":
			    $tasks = Model\Task::all()
			        ->visible()
			        ->eq("parent", $id)
			        ->eq("status", Model\Task::STATUS_BACKLOG);
			    foreach($tasks as $task) {
			        if($task->data("group")) {
			        	$ret[] = new self("backlog/".$task->id());
			        } else {
			            $ret[] = new self("task/".$task->id());
			        }
			    }
			    break;
			case "task":
			    $tasks = Model\Task::all()
			        ->visible()
			        ->eq("status", Model\Task::STATUS_BACKLOG)
					->eq("parent", $id);
			    foreach($tasks as $task) {
			        $ret[] = new self("task/".$task->id());
			    }
			    break;
			    
		}
		
		return $ret;
	}
	
	public function task() {
	    list($type, $id) = explode("/", $this->id);
		$taskId = ($type == "task" || $type == "backlog") ? $id : 0;
	    return Model\Task::get($taskId);
	}
	
	/**
	 * Возвращает название группы
	 **/
	public function title() {
		list($status, $id) = explode("/", $this->id);
		switch($status) {
		    case "request":
		        if(!$id) {
		            return "Заявки";
		        }
		        return Model\Project::get($id)->title();
		    case "backlog":
		    	if($id) {
		            return $this->task()->title();
		        } else {
					return "Бэклог";
				}
		    case "task":
		        return $this->task()->title();
		}
	}
	
	/**
	 * Папка это или нет
	 **/
	public function isGroup() {
		list($status, $id) = explode("/", $this->id);
		switch($status) {
		    default:
		        return true;
		    case "task":
		        return $this->task()->data("group");
		}
		return false;
	}
	
	/**
	 * Возвращает путь группы (хлебные крошки)
	 **/
	public function path() {
		list($status, $id) = explode("/", $this->id);
		$ret = array();
		switch($status) {
		    case "request":
		        if($id) {
					$ret[] = new self($status);
				}
				break;
		    case "backlog":
				$ret[] = new self("backlog");
				break;
		}
		return $ret;
	}

}
