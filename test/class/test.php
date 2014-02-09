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
		//$user->data("email",12121);
		echo "<pre>";
		var_export($user->data());

		\util::profiler();

		\tmp::footer();
        
    }

}
