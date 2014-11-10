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
	public function tasks() {
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
				        $ret[] = $task;
				    }
			    }
			    break;
		}
		
		return $ret;
	}
	
	/**
	 * Возвращает массив подгрупп
	 **/
	public function subgroups() {
		list($status, $id) = explode("/", $this->id);
		$ret = array();
		switch($status) {
		    case "request":
		        if(!$id) {
				    $projects = Model\Project::all()
				        ->visible()
				        ->join("Infuso\Board\Model\Access", "`Infuso\Board\Model\Access`.`projectId` = `Infuso\Board\Model\Project`.`id`");
				    foreach($projects as $project) {
				        $ret[] = new self("request/".$project->id());
				    }
			    }
			    break;
		}
		return $ret;
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
		}
	}

}
