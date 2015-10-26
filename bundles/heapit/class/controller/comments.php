<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use Infuso\Heapit\Model;

class Comments extends Base {
    
    public function post_addComment($p) {
        $data = array(
			"text" => $p["text"],
			"author" => $p["userId"],
			"parent" => $p["parent"],
		);
        $item = service("ar")->create("Infuso\\Heapit\\Model\\Comment", $data);
        if($item->exists()){
            return true;     
        }                           
    }   

    public function post_get($p) {
        $comment = Model\Comment::get($p["id"]);
        return app()->tm("/heapit/comments/editor")
            ->param("comment", $comment)
            ->getContentForAjax();
    }
    
    /**
     * Возвращает html-код списка платежей
     **/
    public function post_search($p) {

        $comments = \Infuso\Heapit\Model\Comment::all()->eq("parent", $p["parent"]);
        $comments->page($p["page"]);


        // Учитываем поиск
        $comments->search($p["search"]);

        $ret = app()->tm("/heapit/comments/ajax")
            ->param("comments", $comments)
            ->getContentForAjax();

        return array(
            "html" => $ret,
            "total" => $comments->pages(),
        );

    }
    
    public function post_save($p) {
        $comment = Model\Comment::get($p["commentId"]);
        $comment->data("text", $p["data"]["text"]);
        app()->msg("Комментарий сохранен");
    }
        
}
