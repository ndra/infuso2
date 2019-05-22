<?

namespace Infuso\Site\Controller;
use Infuso\Site\Model;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Page extends Core\Controller {

	public function postTest() {
	    return true;
	}
	
    public function post_getContent($p) {
    
        $page = \Infuso\Site\Model\Page::get($p["id"]);
        $content = app()
            ->tm("/site/page/content")
            ->param("page", $page)
            ->getContentForAjax();
            
        return array(
            "url" => $page->url(),
            "content" => $content,
            "title" => $page->plugin("meta")->title(),
        );
    }

}
