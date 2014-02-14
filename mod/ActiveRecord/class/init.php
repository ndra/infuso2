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
			$record = mod::service("ar")->virtual($class);
			$migration = new Migration\Table($record->reflex_table());
		}

	}
}
