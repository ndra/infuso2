<?

namespace Infuso\Board\Model;

class Project extends \Infuso\ActiveRecord\Record {

	public function indexTest() {
        if(!app()->user()->checkAccess("board/editProject")) {
            return false;
        }
        return true;
	}

	public function index_item($p) {
	    $project = self::get($p["id"]);
		$this->app()->tm()->exec("/board/project", array(
		    "project" => $project,
		));
	}

    public static function model() {

        return array (
            'name' => "board_project",
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Название проекта',
                ), array (
                    'name' => 'priority',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'editable' => '1',
                    'label' => 'Приоритет',
                ), array (
                    'name' => 'icon',
                    'type' => 'file',
                    'editable' => '1',
                    'label' => 'Иконка',
                ), array (
                    'name' => 'url',
                    'type' => 'string',
                    'editable' => '1',
                    'label' => 'Адрес сайта',
                ), array (
                    'name' => 'completeAfter',
                    'type' => 'bigint',
                    'editable' => '1',
                    'label' => 'Закрывать задачи после (дней)',
                ),
            ),
        );

    }

    /**
     * Возвращает проект по id
     **/
	public static function get($id) {
		return service("ar")->get(get_class(),$id);
	}

	/**
	 * Возвращает список всех проектов
	 **/
	public static function all() {
		return \Infuso\ActiveRecord\Record::get(get_class())
            ->addBehaviour("infuso\\board\\model\\projectcollection")
			->desc("priority");
	}

    /**
     * Возвращает флаг наличия у активного пользователя подписки на этот проект
     **/
	public function isActiveUserHaveSubscription() {
	    $subscriptionKey = "board/project-{$this->id()}/taskCompleted";
	    return !user::active()->subscriptions()->eq("key",$subscriptionKey)->void();
	}

    /**
     * Возвращает коллекцию задач в проекте
     **/
	public function tasks() {
		return Task::all()->eq("projectId",$this->id());
	}

    /**
     * Возвращает иконку проекта
     **/
    public function icon() {
        return $this->pdata("icon");
    }

    /**
     * Загружает фавиконку в качестве иконки проекта
     **/
    public function loadFavicon() {

        if(!$url = trim($this->data("url"))) {
            return;
        }

        $img = imagecreatefrompng("http://www.google.com/s2/favicons?domain={$url}");
        imagesavealpha($img,true);

        $tmp = \file::tmp()."favicon.png";
        imagepng($img, \file::get($tmp)->native());

        $icon = $this->storage()->add($tmp,"favicon.png");
        $this->data("icon",$icon);

    }

    public function accesses() {
        return Access::all()->eq("projectId", $this->id());
    }

}
