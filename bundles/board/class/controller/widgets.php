<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class Widgets extends Base {
    
    public function post_projectSelector($p) {
        $html = app()->tm("/board/shared/project-selector/ajax")
            ->param("search", $p["query"])
            ->getContentForAjax();
        return array(
            "html" => $html,
        );
    }
        
}
