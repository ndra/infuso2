<?

namespace infuso\test;

class tester extends \infuso\core\controller {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
	
	    $record = \mod::service("ar")->virtual("reflex_task");
        $migration = new \Infuso\ActiveRecord\Migration\Table($record->reflex_table());
        //$migration->migrateUp();

        foreach($migration->indexes() as $index) {
			echo "* ";
        }
        
		\util::profiler();

		\tmp::footer();
        
    }

}
