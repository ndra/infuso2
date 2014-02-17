<?

namespace infuso\ActiveRecord;

use Infuso\Core;
use Infuso\Core\Mod;

class Handler implements \Infuso\Core\Handler {

	/**
	 * @handler = infusoInit
	 * @handlerPriority = -1000
	 **/
	public function migration() {

	    Core\Mod::msg("<b>Migrating DB</b>");

	    $v = Mod::service("db")->query("select version()")->exec()->fetchScalar();

	    if(floatval($v)<5) {
	        Mod::msg("You need mysql version 5 or greater. You haver version $v",1);
	        return;
	    }

	    Mod::msg("mysql version {$v} ok");

		// Проходимся по классам и создаем таблицы для них
		foreach(Record::classes() as $class) {

		    try {
				$record = mod::service("ar")->virtual($class);
				$table = $record->recordTable();
				if($table) {
					$migration = new Migration\Table($table);
					$migration->migrateUp();

					// Если во время миграции таблицы были сообщения, выводим их
					$messages = $migration->getMessages();
					if(sizeof($messages)) {
					    mod::msg("Migrating ".$class);
						foreach($messages as $msg) {
							mod::msg($msg);
						}
					}
				}
			} catch(\Exception $ex) {

			    $message = "Error when migrating table for class ".$class.": ".$ex->getMessage();
			    throw new \Exception ($message);
			}
		}

	}

	/**
	 * @handler = infusoInit
	 **/
	public function on_mod_init() {
	
	    \user_operation::create("reflex:editLog","Редактирование лога")
			->appendTo("reflex:viewLog");
			
		\user_operation::create("reflex:viewLog","Редактирование лога")
			->appendTo("admin");

        \reflex_task::add(array(
            "class" => "reflex_handler",
            "method" => "cleanup",
            "crontab" => "0 0 * * *",
        ));
	
	}

    public static function cleanup() {

		// Удаляем старые записи из лога (7 месцев)
		\reflex_log::all()->leq("datetime",util::now()->shiftMonth(-6))->delete();

		// Удаляем старые руты из каталога (7 дней)
		\reflex_editor_root::all()->leq("created",util::now()->shiftDay(-7))->delete();

		// Удаляем старые конструкторы (7 дней)
		\reflex_editor_constructor::all()->leq("created",util::now()->shiftDay(-7))->delete();
		
		// Удаляем старые задачи (60 дней)
		\reflex_task::all()->eq("completed",1)->leq("created",util::now()->shiftDay(-60))->delete();

    }
    
    /**
     * @handler = infusoAppShutdown
     **/
    public function on_mod_appShutdown() {
        Record::storeAll();
    }

}
