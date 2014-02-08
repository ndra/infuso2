<?

namespace infuso\test;

class tester extends \infuso\core\controller {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();

        /*$git = new \Infuso\Update\Github(array(
            "owner" => "ndra",
            "repo" => "infuso2",
            "branch" => "dev",
		));
		//$git->zip();
		$git->zip(); */

		/*foreach(\Infuso\Board\Task::all()->limit(200) as $task) {
		    $task->data("id");
		    echo "* ";
		} */
		
		$task = \Infuso\ActiveRecord\Record::create("Infuso\\Board\\Task");
		var_export($task->data());

		\util::profiler();

		\tmp::footer();
        
    }

}
