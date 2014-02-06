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
		
		$user = \user::active();
		$v = $user->field("email")->value();
		var_export($v);

		\util::profiler();

		\tmp::footer();
        
    }

}
