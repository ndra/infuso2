<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля reflex
 **/  
class Main extends Core\Controller {

	public function indexTest() {
	    return true;
	}
	
	public function index() {
		\tmp::exec("/bundlemanager/main");
	}
    
    public function index_test() {
        $theme = new \Infuso\Cms\BundleManager\Theme;
        //echo "<pre>";
        //var_export($theme->map());
        
        echo $theme->template("/")->depth();
        
        /*foreach($theme->template("/")->children() as $tmp) {
            echo $tmp->relName();
            echo "<br/>";
            foreach($tmp->children() as $sub) {
                echo "<div style='padding-left:20px;' >";
                echo $sub->relName();
                echo "<br/>";
                echo "</div>";
            }
        }    */ 
        
    }

}
