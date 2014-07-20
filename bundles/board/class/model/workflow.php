<?

namespace Infuso\Board\Model;

use  \Infuso\ActiveRecord;
use  \Infuso\Core;

/**
 * Модель записи в логе
 **/
class WorkFlow extends ActiveRecord\Record {

    public static function recordTable() {
        return array (
            'name' => "board_task_workflow",
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'begin',
                    'type' => 'datetime',
                    "default" => "now()",
                    'editable' => 1,
                    'label' => 'Начало',
                ), array (
                    'name' => 'end',
                    'type' => 'datetime',
                    'editable' => 1,
                    'label' => 'Конец',
                ), array (
                    'name' => 'duration',
                    'type' => 'bigint',
                    'editable' => 1,
                    'label' => 'Время',
                ), array (
                    'name' => 'charged',
                    'type' => 'checkbox',
                    'label' => 'Учтено',
                ), array (
                    'name' => 'userId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '2',
                    'label' => 'Пользователь',
                    'class' => 'user',
                ), array (
                    'name' => 'taskId',
                    'type' => 'link',
                    'editable' => '2',
                    'label' => 'Задача',
                    'class' => Task::inspector()->className(),
                ),
            ),
        );
    }

    /**
     * Возвращает коллекцию всех записей в логе
     **/
    public static function all() {
        return service("ar")->collection(get_class())->desc("begin");
    }

    /**
     * Возвращает запись в логе по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
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

    /**
     * Возвращает пользователя от которого сделана запись
     **/
    public function user() {
        return $this->pdata("userId");
    }
    
    public function beforeCreate() {

        $otherFlows = self::all()
            ->eq("userId", $this->data("userId"))
            ->isnull("end");
            
        foreach($otherFlows as $item) {
            $item->data("end", \util::now());
        } 

    }
    
    public function beforeStore() {
        if($this->data("end")) {
            $d = $this->pdata("end")->stamp() - $this->pdata("begin")->stamp();
            $this->data("duration", $d);
        }
    }


}
