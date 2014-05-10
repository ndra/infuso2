<?

namespace Infuso\Board\Model;

use  \Infuso\ActiveRecord;
use  \Infuso\Core;

/**
 * Модель записи в логе
 **/
class TaskTime extends ActiveRecord\Record {

    public static function recordTable() {
        return array (
            'name' => "board_task_time",
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'begin',
                    'type' => 'datetime',
                    'editable' => 1,
                    'label' => 'Начало',
                ), array (
                    'name' => 'end',
                    'type' => 'datetime',
                    'editable' => 1,
                    'label' => 'Конец',
                ), array (
                    'name' => 'charged',
                    'type' => 'checkbox',
                    'label' => 'Учтено',
                ), array (
                    'name' => 'userID',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '2',
                    'label' => 'Пользователь',
                    'class' => 'user',
                ), array (
                    'name' => 'taskID',
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
        return $this->pdata("taskID");
    }

    public function reflex_parent() {
        return $this->task();
    }

    public function reflex_beforeCreate() {
        $this->data("begin", \util::now());
        $this->data("userID", \user::active()->id());
    }

    /**
     * Возвращает пользователя от которого сделана запись
     **/
    public function user() {
        return $this->pdata("userID");
    }


}
