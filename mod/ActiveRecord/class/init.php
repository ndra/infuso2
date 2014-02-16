<?

namespace Infuso\ActiveRecord;
use \infuso\core\mod;
use \infuso\core\file;

class Init extends \mod_init {

	public function priority() {
	    return 9999;
	}

	public function init() {

	    mod::msg("<b>reflex</b>");

	    $v = mod::service("db")->query("select version()")->exec()->fetchScalar();
	    
	    if(floatval($v)<5) {
	        mod::msg("You need mysql version 5 or greater. You haver version $v",1);
	        return;
	    }
	    
	    mod::msg("mysql version {$v} ok");

		// Проходимся по классам и создаем таблицы для них
		foreach(Record::classes() as $class) {
		
		    try {
				$record = mod::service("ar")->virtual($class);
				$table = $record->reflex_table();
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
}
