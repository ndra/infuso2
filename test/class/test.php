<?

namespace infuso\test;

class tester extends \infuso\core\controller {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();

        $user = \user::active();
        foreach($user->behaviourMethods("xxx") as $fn) {
            
        }
		//$user->callBehaviours("xxx");

		\util::profiler();

		\tmp::footer();
        
    }

}
