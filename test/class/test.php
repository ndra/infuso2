<?

namespace infuso\test;

class tester extends \infuso\core\controller {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
	
	   /* $record = \mod::service("ar")->virtual("reflex_task");
        $migration = new \Infuso\ActiveRecord\tableMigration($record->reflex_table());
        $migration->migrateUp(); */
        
        $user = \user::active();
        $user->addBehaviour("infuso\\test\\behaviour");
        
        for($i=0;$i<1000;$i++) {
        	$user->xxx();
        }
        
		\util::profiler();

		\tmp::footer();
        
    }

}
