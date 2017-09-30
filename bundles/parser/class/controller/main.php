<?

namespace Infuso\Parser\Controller;
use \Infuso\Core;

/**
 * Контроллер для авторизации через соцсети
 **/
class Main extends Core\Controller {

    public function controller() {
        return "parser";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
    
        app()->tm()->header();

        foreach(\Infuso\Parser\Model\Project::all() as $project) {
            $project->parseStep();
        }
        
        echo "<script>window.location.reload();</script>";
        
        app()->tm()->footer();
        
    }

}
