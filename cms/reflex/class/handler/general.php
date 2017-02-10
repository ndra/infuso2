<?

namespace Infuso\Cms\Reflex\Handler;
use Infuso\Cms\Reflex\Model;

use \user_role, \user_operation;
use \mod, \file, \util;
use Infuso\Core;

class General extends Core\Component implements Core\Handler {

	/**
	 * @handler = infuso/deploy
	 * @handlerPriority = -1
	 **/
	public function removeRootTabs() {
	    app()->msg("removing root tabs");
        Model\RootTab::removeAll();
	}

	/**
	 * @handler = infuso/deploy
	 **/
	public function initReflex() {
	
	    // Создаем роль «Контент-менеджер»
	    
	    $role = user_role::create("reflex:content-manager", "Контент-менеджер");
	    $role->appendTo("admin");
	    user_operation::get("admin:showInterface")->appendTo("reflex:content-manager");
	    
	    // Добавляем операции
	
	    $op = user_operation::create("reflex:editItem");
	    $op->appendTo("reflex:content-manager");
	    
	    $op = user_operation::create("reflex:editConfValue", "Редактирование значения настройки")
			->appendTo("admin");
			
		$op = user_operation::create("reflex:viewConf", "Просмотр настроек")
			->appendTo("admin");
			
		// Добавляем вкладки в каталоге
        Model\rootTab::create(array(
            "title" => "Контент",
            "name" => "",
            "icon" => self::inspector()->bundle()->path()."/res/icons/48/content.png",
            "priority" => 1000,
		));
		
        Model\rootTab::create(array(
            "title" => "Системные",
            "name" => "system",
            "icon" => self::inspector()->bundle()->path()."/res/icons/48/system.png",
		));
		
		self::buildEditorMap();

	}
	
	/**
	 * Строит карту редакторов
	 **/
	public static function buildEditorMap() {
	    $map = array();
		foreach(service("classmap")->classes("infuso\\cms\\reflex\\editor") as $class) {
		    $e = new $class;
		    $map[$e->itemClass()][] = $class;
		}
		$path = mod::app()->varPath()."/reflex/editors.php";
		file::mkdir(file::get($path)->up());
		util::save_for_inclusion($path, $map);
	}
	
	/**
	 * @handler = infuso/deploy
	 **/
	public function onDeploy() {

	    \user_operation::create("reflex:editLog", "Редактирование лога")
			->appendTo("reflex:viewLog");

		\user_operation::create("reflex:viewLog", "Просмотр лога")
			->appendTo("admin");

        service("task")->add(array(
            "class" => get_class(),
            "method" => "cleanup",
            "crontab" => "0 0 * * *",
            "randomize" => 120,
        ));

	}
    
    /**
     * @handler = infuso/beforeActionSYS
     **/         
    public function addMeta() {   
        //$ar = app()->action()->ar();
        //list($class,$id) = explode("/", $ar);
        $record = app()->action()->record();
        $metaObject = $record->plugin("meta")->metaObject();
        app()->tm()->param("head/title", $metaObject->data("title"));
		app()->tm()->param("head/keywords", $metaObject->data("keywords"));
        app()->tm()->param("head/description", $metaObject->data("description"));
        app()->tm()->param("head/noindex", $metaObject->data("noindex"));
        app()->tm()->param("head/insert", $metaObject->data("head"));
    }
    
	/**
	 * Вызывается до старта контроллера
	 * Если вызван метод className::item класса, наследуемого от reflex,
	 * то устанавливам текущий объект action::ar()
	 * @handler = infuso/beforeActionSYS  
	 * @handlerPriority = -1        
	 **/
	public static function onbeforeActionSys($p) { 
		$action = $p->param("action");
        if(is_subclass_of($action->className(), "infuso\\cms\\reflex\\editor")) {
            if($action->action() == "child") {
                \Infuso\Cms\Reflex\Keeper::set($action->className(), $action->param("id"), $action->param("method"));
            }
            if($action->action() == "index") {
                \Infuso\Cms\Reflex\Keeper::set($action->className(), $action->param("id"), null);
            }
        } 	
	}

	/**
	 * Запускается как задача раз в день
	 * Очищает каталог от мусора
	 **/
    public static function cleanup() {     
		// Удаляем старые конструкторы (7 дней)
		Model\Constructor::all()
            ->leq("created", \util::now()->shiftDay(-7))
            ->delete(); 
    }
    
	
}
