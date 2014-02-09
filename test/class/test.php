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

		$user = \user::active();

		\util::profiler();

		\tmp::footer();
        
    }

}
