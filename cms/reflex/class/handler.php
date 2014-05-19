<?

namespace Infuso\Cms\Reflex;

use \user_role, \user_operation;
use \mod, \file, \util;
use Infuso\Core;

class Handler extends Core\Component implements Core\Handler {

	/**
	 * @handler = infusoDeploy
	 * @handlerpriority = -1
	 **/
	public function removeRootTabs() {
	    \mod::msg("removing root tabs");
        rootTab::removeAll();
	}

	/**
	 * @handler = infusoDeploy
	 **/
	public function initReflex() {
	
	    // Создаем роль «Контент-менеджер»
	    
	    $role = user_role::create("reflex:content-manager","Контент-менеджер");
	    $role->appendTo("admin");
	    user_operation::get("admin:showInterface")->appendTo("reflex:content-manager");
	    
	    // Добавляем операции
	
	    $op = user_operation::create("reflex:editItem");
	    $op->appendTo("reflex:content-manager");
	    
	    $op = user_operation::create("reflex:editConfValue","Редактирование значения настройки")
			->appendTo("admin");
			
		$op = user_operation::create("reflex:viewConf","Просмотр настроек")
			->appendTo("admin");
			
		// Добавляем вкладки в каталоге
        rootTab::create(array(
            "title" => "Контент",
            "name" => "",
            "icon" => self::inspector()->bundle()->path()."/res/icons/48/content.png",
            "priority" => 1000,
		));
		
        rootTab::create(array(
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
		foreach(\mod::service("classmap")->classes("infuso\\cms\\reflex\\editor") as $class) {
		    $e = new $class;
		    $map[$e->itemClass()][] = $class;
		}
		$path = mod::app()->varPath()."/reflex/editors.php";
		file::mkdir(file::get($path)->up());
		util::save_for_inclusion($path,$map);
	}
	
	/**
	 * @handler = infusoDeploy
	 **/
	public function onDeploy() {

	    \user_operation::create("reflex:editLog","Редактирование лога")
			->appendTo("reflex:viewLog");

		\user_operation::create("reflex:viewLog","Редактирование лога")
			->appendTo("admin");

        \mod::service("task")->add(array(
            "class" => get_class(),
            "method" => "cleanup",
            "crontab" => "0 0 * * *",
        ));

	}

	/**
	 * Запускается как задача раз в день
	 * Очищает каталог от мусора
	 * @todo включить функцию     
	 **/
    public static function cleanup() {
    
        return;

		// Удаляем старые записи из лога (7 месцев)
		\reflex_log::all()->leq("datetime",util::now()->shiftMonth(-6))->delete();

		// Удаляем старые руты из каталога (7 дней)
		\reflex_editor_root::all()->leq("created",util::now()->shiftDay(-7))->delete();

		// Удаляем старые конструкторы (7 дней)
		\reflex_editor_constructor::all()->leq("created",util::now()->shiftDay(-7))->delete();

		// Удаляем старые задачи (60 дней)
		\reflex_task::all()->eq("completed",1)->leq("created",util::now()->shiftDay(-60))->delete();

    }
	
}
