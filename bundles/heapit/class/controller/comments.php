<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use Infuso\Heapit\Model;

class Comments extends Base {
    
    public function post_list($p) {
        $comments = Model\Comment::all()->eq("parent", $p["parent"]);
        $tmp = \tmp::get("/heapit/comments/ajax");
        $tmp->param("comments", $comments);
        return $tmp->getContentForAjax();
    } 
    
    
    public function post_addComment($p) {
        $data = array("text" => $p["text"], "author" => $p["userId"], "parent" => $p["parent"]);
        $item = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Comment", $data);
        if($item->exists()){
            return true;     
        }                           
    }   

    public function post_get($p) {
        Core\Mod::msg($p);
        return 12;
    }
        
}
