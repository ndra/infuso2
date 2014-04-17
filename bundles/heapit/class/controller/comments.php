<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use Infuso\Heapit\Model;

class Comments extends Base {
    
    public function post_list($p) {
        $comments = Model\Comment::all();
        $tmp = \tmp::get("/heapit/org/right-tabs/comments/ajax");
        $tmp->param("comments", $comments);
        return $tmp->getContentForAjax();
    } 
    
    public function post_addComment($p) {
        $data = array("text"=> $p["text"], "author"=> $p["userId"]);
        return "Hello";                            
    }   
        
}
