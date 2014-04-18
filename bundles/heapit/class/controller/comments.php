<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use Infuso\Heapit\Model;

class Comments extends Base {
    
    public function post_list($p) {
        $comments = Model\Comment::all()->eq("parent", "org:".$p["orgId"]);
        $tmp = \tmp::get("/heapit/org/right-tabs/comments/ajax");
        $tmp->param("comments", $comments);
        return $tmp->getContentForAjax();
    } 
    
    public function post_addComment($p) {
        $parent = "org:".$p["orgId"];
        $data = array("text" => $p["text"], "author" => $p["userId"], "parent" => $parent);
        $item = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Comment", $data);
        if($item->exists()){
            return true;     
        }
                                   
    }   
        
}
