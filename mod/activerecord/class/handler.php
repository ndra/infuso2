<?

namespace infuso\ActiveRecord;

use Infuso\Core;
use Infuso\Core\Mod;

class Handler implements \Infuso\Core\Handler {

	/**
	 * @handler = infuso/deploy
	 * @handlerPriority = -1000
	 * При инициализации приводим таблицы в БД в соответствии с макетами
	 **/
	public function onDeploy() {

	    app()->msg("<b>Migrating DB</b>");

	    $v = service("db")->query("select version()")->exec()->fetchScalar();

	    if(floatval($v) < 5) {
	        app()->msg("You need mysql version 5 or greater. You haver version $v",1);
	        return;
	    }

	    app()->msg("mysql version {$v} ok");
        
        self::renameOldTables();

		// Проходимся по классам и создаем таблицы для них
		foreach(Record::classes() as $class) {

		    try {
				$record = new $class();
				$table = $record->modelExtended("");
				if($table) {
					$migration = new Migration\Table($table);
					$migration->migrateUp();

					// Если во время миграции таблицы были сообщения, выводим их
					$messages = $migration->getMessages();
					if(sizeof($messages)) {
					    app()->msg("Migrating ".$class);
						foreach($messages as $msg) {
							app()->msg($msg);
						}
					}
				}
			} catch(\Exception $ex) {

			    $message = "Error when migrating table for class ".$class.": ".$ex->getMessage();
			    throw new \Exception ($message);
			}
		}

	}
    
    public static function renameOldTables() {
    
        $q = service("db")->query("show tables");
        $result = $q->exec();
        while($oldName = $result->fetchScalar()) {                 
            // Проходимся по классам и создаем таблицы для них
    		foreach(Record::classes() as $class) {
                $newName = $class::prefixedTableName(); 
                if($class::prepareName($oldName) == $newName && $newName != $oldName) {
                    $query = "rename table `$oldName` to `$newName` ";
                    app()->msg($query);
                    service("db")->query($query)->exec();
                }
            }                 
        }
    
    }
    
    /**
     * @handler = infuso/defer
     * При завершении приложения сохраняем все измененные записи
     **/
    public function onDefer() {
        Record::storeAll();
    }

}
