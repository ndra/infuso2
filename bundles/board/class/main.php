<?

namespace Infuso\Board;

use \User;
use \Tmp;

class Main extends \Infuso\Core\Controller {

    public static function indexTest() {
        return user::active()->exists();
    }
    
    public static function indexFailed() {
        exec("board:login");
    }
    
    public static function index() {
        exec("/board/main");
    }

    public function index_test() {
        
        header();
        
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->text("Я кнопка")
            ->exec();
        
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->exec();
            
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->text("Я кнопка")
            ->icon("edit")
            ->exec();
            
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->air()
            ->exec();
            
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->air()
            ->exec();
            
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->air()
            ->exec();
            
        $w = widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->text("Я кнопка")
            ->icon("edit")
            ->exec();
        
        footer();
  
    }

}
