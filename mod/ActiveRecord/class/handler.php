<?

namespace infuso\ActiveRecord;

use Infuso\Core;
use Infuso\Core\Mod;

class Handler implements \Infuso\Core\Handler {

	/**
	 * @handler = infusoInit
	 * @handlerPriority = -1000
	 * При инициализации приводим таблицы в БД в соответствии с макетами
	 **/
	public function onInfusoInit() {

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
				$record = new $class();
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
     * @handler = infusoAppShutdown
     * При завершении приложения сохраняем все измененные записи
     **/
    public function onAppShutdownSys() {
        Record::storeAll();
    }

}
