<?

namespace Infuso\Board\Model;

use  \Infuso\ActiveRecord\Record;
use  \User;

/**
 * Модель записи в логе
 **/
class Log extends Record {

    const TYPE_COMMENT = 1;
    const TYPE_TASK_MODIFIED = 3;
    const TYPE_TASK_STOPPED = 6;
    const TYPE_TASK_TAKEN = 7;
    const TYPE_TASK_DONE = 8;
    const TYPE_TASK_CHECKED = 9;
    const TYPE_TASK_REVISED = 10;
    const TYPE_TASK_CANCELLED = 11;

    public static function model() {
        return array (
            'name' => 'board_task_log',
            'fields' => array (
                array (
                  'name' => 'id',
                  'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                  'name' => 'created',
                  'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                  'editable' => '2',
                  'label' => 'Время записи',
                  "default" => "now()",
                ), array (
                  'name' => 'userId',
                  'type' => 'pg03-cv07-y16t-kli7-fe6x',
                  'editable' => '2',
                  'label' => 'Пользователь',
                  'class' => \User::inspector()->className(),
                ), array (
                  'name' => 'taskId',
                  'type' => 'pg03-cv07-y16t-kli7-fe6x',
                  'editable' => '2',
                  'label' => 'Задача',
                  'indexEnabled' => '1',
                  'class' => Task::inspector()->className(),
                ), array (
                  'name' => 'text',
                  'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
                  'editable' => '1',
                  'label' => 'Текст',
                  'indexEnabled' => '0',
                ), array (
                    'name' => 'type',
                    'type' => 'select',
                    'editable' => '1',
                    'label' => 'Тип',
                    'values' => self::enumTypes(),
                ), array (
                    'name' => 'files',
                    'type' => 'string',
                    'editable' => '2',
                    'label' => 'Папка с файлами',
                ),
            ),
        );
    }
    
    public static function enumTypes() {
        return array(
		    self::TYPE_COMMENT => "Комментарий",
		    self::TYPE_TASK_MODIFIED => "Изменено",
		    self::TYPE_TASK_STOPPED => "Остановлена",
		    self::TYPE_TASK_TAKEN => "Взято",
		    self::TYPE_TASK_DONE => "Выполнено",
		    self::TYPE_TASK_CHECKED => "Проверено",
		    self::TYPE_TASK_REVISED => "Возвращено",
		    self::TYPE_TASK_CANCELLED => "Отменено",
		);

    }

    /**
     * Возвращает коллекцию всех записей в логе
     **/
    public static function all() {
        return Record::get(get_class())->desc("created");
    }

    /**
     * Возвращает запись в логе по id
     **/
    public static function get($id) {
        return Record::get(get_class(),$id);
    }
    
    /**
     * Возвращает задачу к которой относится запись в логе
     **/
    public function task() {
        return $this->pdata("taskId");
    }

    public function recordParent() {
        return $this->task();
    }

    public function beforeCreate() {
        $this->data("userId",\user::active()->id());
    }

    public function afterStore() {
        app()->fire("board/log-changed", array(
            "deliverToClient" => true,
        ));
    }

    /**
     * Возвращает пользователя от которого сделана запись
     **/
    public function user() {
        return $this->pdata("userId");
    }

    /**
     * Возвращает текст записи
     **/
    public function message() {
        return $this->data("text");
    }

    /**
     * Возвращает текст записи
     **/
    public function msg() {
        return $this->message();
    }

    /**
     * Возвращает текст записи
     **/
    public function text() {
        return $this->message();
    }

    /**
     * Возвращает список файлов, прикрепелнных к записи лога
     * (не путать с файлами задачи)
     **/
    public function files() {     
        if($this->data("files")) {
            return $this->task()->storage()->setPath("/log/".$this->data("files"))->files();
        } else {
            return array();
        }
    }
    
	/**
	 * Возвращает иконку статуса 16x16
	 **/
    public function icon16() {
    
        $icon = "";
        switch($this->data("type")) {
            default:
            case self::TYPE_COMMENT:
                $icon = "message";
                break;
            case self::TYPE_TASK_MODIFIED:
            	$icon = "modified";
                break;
		    case self::TYPE_TASK_STOPPED:
		    	$icon = "stop";
		        break;
		    case self::TYPE_TASK_TAKEN:
		        $icon = "take";
		        break;
		    case self::TYPE_TASK_DONE:
		        $icon = "done";
		        break;
		    case self::TYPE_TASK_CHECKED:
		        $icon = "checked";
		        break;
		    case self::TYPE_TASK_REVISED:
		        $icon = "revised";
		        break;
			case self::TYPE_TASK_CANCELLED:
				$icon = "cancel";
			    break;
        }
        
        return self::inspector()->bundle()->path()."/res/img/icons16/{$icon}.png";                    
    }

}
