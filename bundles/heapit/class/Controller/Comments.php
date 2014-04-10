<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use Infuso\Heapit\Model;

class Comments extends Core\Controller {
    
    public static function postTest() {
        return true;
    }
    
    public function post_list($p) {
    
        $comments = Model\Comment::all();
    
        $tmp = \tmp::get("/heapit/org/right-tabs/comments/ajax");
        $tmp->param("comments", $comments);
        return $tmp->getContentForAjax();
    }    
        
}
