<?

namespace Infuso\Board\Model;

use \User;
use \mod, \Util;
use Infuso\Core;
use Infuso\Board\Controller;

class Task extends \Infuso\ActiveRecord\Record {

    const STATUS_DEMAND = 200;
    const STATUS_REQUEST = 200;
    const STATUS_BACKLOG = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_CHECKOUT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DRAFT = 10;
    const STATUS_CANCELLED = 100;
    const STATUS_PROBLEM = 300;
    
    private $touchedStatus = array();

    public function indexTest() {
        return true;
    }

    public function index_item($p) {
        $task = self::get($p["id"]);
        $this->app()->tm()->exec("/board/task", array(
            "task" => $task,
        ));
    }

    public static function model() {
    
        return array(
            'name' => 'board_task',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'unique',
                    'type' => 'string',
                ), array (
                    'name' => 'text',
                    'label' => "Описание задачи",
                    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
                    'editable' => '1',
                ), array (
                    'label' => "Статус задачи",
                    'name' => 'status',
                    'type' => 'select',
                    'values' => self::enumStatuses(),
                    'editable' => '1',
                ), array (
                    'name' => 'priority',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'label' => 'Приоритет',
                ), array (
                    'name' => 'created',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    "default" => "now()",
                    "editable" => 2,
                ), array (
                    'name' => 'creator',
                    'type' => 'link',
                    "editable" => 2,
                    "label" => "Автор задачи",
                    'class' => User::inspector()->className(),
                ), array (
                    'name' => 'changed',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    "label" => "Изменено",
                    "default" => "now()",
                    "editable" => 2,
                ), array (
                    'name' => 'projectId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'class' => Project::inspector()->className(),
                    "label" => "Проект",
                    "editable" => 1,
                ), array (
                    'name' => 'timeScheduled',
                    'type' => 'yvbj-cgin-m90o-cez7-mv2j',
                    'label' => 'Планируемое время',
                    "editable" => 1,
                ), array (
                    'name' => 'timeSpent',
                    'type' => 'yvbj-cgin-m90o-cez7-mv2j',
                    'label' => 'Потрачено времени',
                    "editable" => 2,
                ), array (
                    'name' => 'responsibleUser',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'label' => User::inspector()->className(),
                    "class" => "\\Infuso\\User\\Model\\User",
                    "editable" => 2,
                ), array (
                    'name' => 'deadline',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    "editable" => 1,
                    "label" => "Дэдлайн"
                ), array (
                    'name' => 'deadlineDate',
                    'type' => 'ler9-032r-c4t8-9739-e203',
                    "editable" => 1,
                ), array (
                    'name' => 'files',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'label' => 'Количество файлов',
                    'editable' => 2,
                ), array (
                    'name' => 'group',
                    'type' => 'checkbox',
                    'label' => 'Это граппа задач',
                    'editable' => 2,
                ), array (
                    'name' => 'parent',
                    'type' => 'link',
                    "class" => get_class(),
                    'label' => 'Группа',
                    'editable' => 2,
                ),
            ),
        );
    }

	public static function enumStatuses() {
	    return array(
	        self::STATUS_DEMAND => "Заявка",
		    self::STATUS_BACKLOG => "Бэклог",
		    self::STATUS_IN_PROGRESS => "Выполняется",
		    self::STATUS_CHECKOUT => "На проверке",
		    self::STATUS_COMPLETED => "Выполнено",
		    self::STATUS_DRAFT => "Черновик",
		    self::STATUS_CANCELLED => "Отменено",
            self::STATUS_PROBLEM => "Проблемы",
	    );
	}

    /**
     * Возвращает список всех задач
     **/
    public static function all() {
        return \Infuso\ActiveRecord\Record::get(get_class())
            ->addBehaviour("Infuso\\Board\\Model\\CollectionBehaviour")
            ->asc("priority");
    }

    /**
     * Возвращает задлачу по id
     **/
    public static function get($id) {
        return \Infuso\ActiveRecord\Record::get(get_class(),$id);
    }

    /**
     * Возвращает проект
     **/
    public function project() {
        return $this->pdata("projectId");
    }

    /**
     * Возвращает родителя записи, т.е. проект
     **/
    public function recordParent() {
        return $this->project();
    }

    public function recordTitle() {
        return \util::str($this->data("text"))->ellipsis(50)."";
    }

    public function text() {
        return $this->data("text");
    }

    public function responsibleUser() {
        return $this->pdata("responsibleUser");
    }

    public function beforeCreate() {
        $this->data("creator",user::active()->id());
    }
    
    public function sentToBeginning() {
        if($this->data("status") == self::STATUS_BACKLOG) {
            $min = Task::all()->eq("status",self::STATUS_BACKLOG)->min("priority");
            $this->data("priority",$min - 1);
        }
    }

    /**
     * Триггер перед сохранением хадачи
     **/
    public function beforeStore() {
    
        $this->updateUnique();

        // Устанавливаем новую дату изменения только если задача активна
        // Иначе мы можем влезть в статистику по прошлому периоду
        if($this->field("status")->changed()) {
            $this->data("changed",util::now());
            // При переходи задачи в статус к исполнению она ставится на первое место
            $this->sentToBeginning();
            $this->finalizeWorkflow();
        }

        // Если статус задачи "к исполнению", ответственным лицом становится текущий пользователь.
        if($this->field("status")->changed() && $this->data("status") == self::STATUS_CHECKOUT) {
            app()->fire("board/task/done", array(
                "task" => $this,
            ));
        }
        
        $status = $this->field("status")->initialValue();
        $this->touchedStatus[] = $status;

    }
    
    public function updateUnique() {
		$this->data("unique", \util::id());
    }
    
    /**
     * Возвращает текст статуса задачи
     **/
    public function statusText() {
        return $this->pdata("status");
    }
    
    /**
     * Вызывает сообщение об изменении задачи (добавляет отложенную функцию)
     **/
    public function fireChangedEvent() {
        $this->defer("fireChangedEventDefer");
    }

    /**
     * Вызывает сообщение об изменении задачи
     **/
    public function fireChangedEventDefer() {
    
        $status = $this->touchedStatus;
        $status[] = $this->data("status");      
        $status = array_unique($status);
        
        if(sizeof($status) > 1) {
            $data = array(
                "deliverToClient" => true,
            );
            $group = new Controller\Pseudogroup("");
            foreach($group->subgroups() as $sub) {
                $data["groups"][$sub->id()] = $sub->count();
            }
            app()->fire("board/groupsChanged", $data);
        }
    
        app()->fire("board/taskChanged",array(
            "deliverToClient" => true,
            "taskId" => $this->id(),
            "toolbarLarge" => app()->tm("/board/shared/task-tools")->param("task", $this)->getContentForAjax(),
            "statusText" => $this->statusText(),
            "touchedStatus" => $status,
		));
    }

    public function afterStore() {
        $this->fireChangedEvent();
    }

	/**
	 * Обновляет потраченное время
	 **/
    public function updateTimeSpent() {
        $this->data("timeSpent",$this->workflow()->eq("status",Workflow::STATUS_MANUAL)->sum("duration"));
    }

    /**
     * Возвращает потраченное но еще неучтенное времия
     * Если вы делавете задачу уже два часа, но еще не сделали, timeSpent() вернет 2 * 3600
     * Время возвращается в секундах
     **/
    public function timeSpentProgress($userId = null) {
    
        if($this->data("status") != self::STATUS_IN_PROGRESS) {
            return 0;
        }
        
        $workflow = $this->workFlow();
        
        if($userId) {
            $workflow->eq("userId", $userId);
        }

        // Предыдущие интервалы
        $a = $workflow->copy()->eq("status",Workflow::STATUS_DRAFT)->sum("duration");

        // Текущий интервал
        $b = $workflow->copy()->eq("status",Workflow::STATUS_DRAFT)->isnull("end")->select("SUM(TIMESTAMPDIFF(SECOND,`begin`,now()))");
        $b = end(end($b))*1;

        return $a + $b;

    }
    
    public function chargeTime($users) {
        foreach($users as $user => $duration) {
            $x = $this->workflow()->create(array(
                "userId" => $user,
                "begin" => \util::now()->shift(-$duration),
                "end" => \util::now(),
                "status" => Workflow::STATUS_MANUAL,
            ));
        }
        $this->finalizeWorkflow();
        $this->updateTimeSpent();
    }

    public function getLog() {
        return Log::all()->eq("taskId",$this->id());
    }

    public function log($params) {
        $this->getLog()->create(array(
            "taskId" => $this->id(),
            "type" => $params["type"],
            "text" => $params["text"], 
            "files" => $params["files"],
        ));
    }

    public function workFlow() {
        return workFlow::all()->eq("taskId",$this->id());
    }

    /**
     * Возвращает время, потраченное на задачу (в секундах)
     **/
    public function timeSpent() {
        return $this->data("timeSpent");
    }

    /**
     * Возвращает планируемое время
     **/
    public function timeScheduled() {
        return $this->data("timeScheduled");
    }

    /**
     * Возвращает число, показывающее сколько дней задача не меняла статус
     **/
    public function hangDays() {
        return round((util::now()->stamp() - $this->pdata("changed")->stamp())/60/60/24);
    }

    /**
     * Возвращает массив допустимых операций с задачей
     **/
    public function tools() {

        if(!user::active()->checkAccess("board/editTask",array(
            "task" => $this,
        ))) {
            return array();
        }

        $tools = array(
            "main" => array(),
            "additional" => array(),
        );

        switch($this->data("status")) {

            case self::STATUS_IN_PROGRESS:

                if($this->activeCollaborators()->eq("id",app()->user()->id())->void()) {
                    $tools["main"][] = "take";  
                } else {
                    $tools["main"][] = "done";
                    $tools["main"][] = "pause";
                }

                $tools["additional"][] = "problem";
                $tools["additional"][] = "stop";
                $tools["additional"][] = "cancel";

                break;

            case self::STATUS_BACKLOG:
  
                $tools["main"][] = "take";   
                $tools["main"][] = "cancel";
                $tools["additional"][] = "problem";

                break;

            case self::STATUS_DEMAND:

                $tools["main"][] = "take";
                $tools["main"][] = "problem";
                $tools["additional"][] = "cancel";

                break;

            case self::STATUS_CHECKOUT:

                $tools["main"][] = "complete";
                $tools["main"][] = "revision";
                $tools["additional"][] = "cancel";
                break;

            case self::STATUS_COMPLETED:

                $tools["additional"][] = "revision";
                break;
                
            case self::STATUS_CANCELLED:

                $tools["additional"][] = "revision";
                break;
                
            case self::STATUS_PROBLEM:
                $tools["main"][] = "revision";
                $tools["main"][] = "cancel";
                break;

                

        }

        return $tools;
    }
    
	/**
	 * Делает попытку закрыть задачу автоматически
	 **/
    public function tryAutocomplete() {

        // Если задача не на проверке - выходим
        if($this->data("status") != TaskStatus::STATUS_CHECKOUT) {
            return;
        }
    
        $days = $this->project()->data("completeAfter");
        if(!$days) {
            return;
        }
        
        $taskDays = (util::now()->date()->stamp() - $this->pdata("changed")->date()->stamp()) / 3600 / 24;
        if($taskDays >= $days) {
            $this->data("status",TaskStatus::STATUS_COMPLETED);
            $this->logCustom("Закрыто автоматически");
        }
    
    }
    
    /**
     * Взять задачу от имени пользователя $user   
     **/     
    public function take($user) {         
        app()->msg("Берем задачу ".$this->id());          
        $this->data("status", self::STATUS_IN_PROGRESS);
        $this->store();
        $this->workflow()->create(array(
            "taskId" => $this->id(),
            "userId" => $user->id(),
        ));
        
        $this->log(array(
            "type" => Log::TYPE_TASK_TAKEN,
        ));
    }
    
    /**
     * Ставит задачу на паузу
     **/
    public function pause($user) {
        if($this->data("status") == self::STATUS_IN_PROGRESS) {
	        $flow = $this->workflow()
				->eq("userId", $user->id())
				->isnull("end")
				->one();
			if($flow->exists()) {
				$flow->data("end", \util::now());
		        $this->log(array(
		            "type" => Log::TYPE_TASK_PAUSED,
		        ));
			}
		}
    }
    
    public function finalizeWorkflow() {
		$this->workflow()
			->eq("status", Workflow::STATUS_DRAFT)
			->isnull("end")
			->data("end", \util::now());

		$this->workflow()
			->eq("status", Workflow::STATUS_DRAFT)
			->data("status", Workflow::STATUS_AUTO);
    }
    
    /**
     * Возвращает список участников задачи
     **/         
    public function collaborators() {
        $userIdList = $this->workflow()->distinct("userId");
        return \Infuso\User\Model\User::all()->eq("id",$userIdList);
    }
    
    /**
     * Возвращает список участников задачи
     **/         
    public function activeCollaborators() {
        $userIdList = $this->workflow()->isnull("end")->distinct("userId");
        return \Infuso\User\Model\User::all()->eq("id",$userIdList);
    }
    
    /**
     * Возвращает все подзадачи в группе
     **/         
    public function subtasks() {
        return self::all()->eq("parent", $this->id());
    }
    
    /**
     * Возвращает коллекцию объектов доступа, связанных с этой группой
     **/         
    public function access() {  
        return Access::all()->eq("groupId", $this->id());
    }

    /**
     * Возвращает полный урл, с схемой и хостом.
     **/
    public function fullUrl() {
        $urlObj = \Infuso\Core\Url::current();
        return $urlObj->scheme().'://'.$urlObj->host().$this->url();
    }
    
    public function recordURL() {
        return new \Infuso\Core\Action(\Infuso\Board\Controller\Main::inspector()->className(), "task", array("id" => $this->id())); 
    }

    /**
     * Отправляет письмо подписчикам (Это участники, автор и те кто комментировал)
     **/
    public function emailSubscribers($params) {
    
        $users = $this->getLog()->distinct("userId");
        $users[] = $this->data("creator");
        $users = array_unique($users);
        
        foreach($users as $userId) {

            $user = service("user")->get($userId);
            $email = $user->email();
            if($user->id() != app()->user()->id()) {
            
	            $mail = service("mail")->create()
					->to($email)
					->code($params["code"])
					->param("task-id", $this->id())
					->param("task-url", $this->fullUrl())
					->param("task-title", $this->title())
                    ->param("task-text-short", \util::str($this->data("text"))->ellipsis(250).""); 
					
				if($params["type"]) {
					$mail->type($params["type"]);
				}
					
				foreach($params as $key => $val) {
				    $mail->param($key, $val);
				}
				
				$mail->send();
			}
        }    
    }

}
