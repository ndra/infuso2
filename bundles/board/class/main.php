<?

namespace Infuso\Board;

use \User;
use \Tmp;

class Main extends \Infuso\Core\Controller {

    public static function indexTest() {
        return user::active()->exists();
    }
    
    public static function indexFailed() {
        tmp::exec("board:login");
    }
    
    public static function index() {
        tmp::exec("/board/main");
    }

    public function index_test() {
        
        tmp::header();
        
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->text("Я кнопка")
            ->exec();
        
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->exec();
            
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->text("Я кнопка")
            ->icon("edit")
            ->exec();
            
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->air()
            ->exec();
            
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->air()
            ->exec();
            
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->icon("edit")
            ->air()
            ->exec();
            
        $w = \tmp::widget("Infuso\\Cms\\UI\\Widgets\\Button")
            ->text("Я кнопка")
            ->icon("edit")
            ->exec();
        

        tmp::footer();
        
        
    }

}
