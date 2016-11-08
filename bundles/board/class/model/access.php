<?

namespace Infuso\Board\Model;
use \Infuso\Core;

class Access extends \Infuso\ActiveRecord\Record {

    public static function model() {

        return array(
            'name' => 'board_access',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'userId',
                    'type' => 'link',
                    'class' => \user::inspector()->className(),
                ), array (
                    'name' => 'projectId',
                    'type' => 'link',
                    'label' => "ID Проекта",
                    'class' => Project::inspector()->className(),
                ),
            ),
        );
    }

	/**
	 * Возвращает список всех объектов
	 **/
	public static function all() {
		return service("ar")->collection(get_class());
	}

    /**
     * Возвращает объект
     **/	     
	public static function get($id) {
		return \Infuso\ActiveRecord\Record::get(get_class(),$id);
	}

    public function user() {
        return $this->pdata("userId");
    }

    public function group() {
        return $this->pdata("groupId");
    }
    
	public function project() {
	    return $this->pdata("projectId");
	}

}
