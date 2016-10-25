<?

namespace Infuso\Parser\Model;
use Infuso\Core;

class Page extends \Infuso\ActiveRecord\Record {

    public static function model() {
    
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'url',
                    'label' => "URL",
                    'type' => 'textarea',
                    'editable' => 1,
                ), array (
                    'name' => 'html',
                    'label' => "HTML",
                    'type' => 'html',
                    'editable' => 1,
                ),  array (
                    'name' => 'projectId',
                    'label' => "Проект",
                    'type' => 'link',
                    "class" => Project::inspector()->className(),
                    'editable' => 2,
                ),
            ),
        );
    }

    /**
     * Возвращает список всех страниц
     **/
    public static function all() {
        return service("ar")->collection(get_class());
    }

    /**
     * Возвращает страницу по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public function recordTitle() {
        return $this->data("url");
    }
    
    public function project() {
        return $this->pdata("projectId");
    }
    
    public function parse() {
    
        echo $this->data("url"); 
    
        $projectURL = new \Infuso\Core\Url($this->project()->data("url"));
        
        $rawHTML = Core\File::http($this->data("url"))->contents();
        $html = new \Infuso\Parser\HTML($rawHTML);
        foreach($html->xpath("//a") as $a) {
            $url = new \Infuso\Core\Url($a->attr("href"));
            if(!$url->domain()) {
                $url->domain($projectURL->domain());
                $url->scheme($projectURL->scheme());
            }
            
            if(strpos((String)$url, (String)$projectURL) === 0) {            
                
                // Добавляем страницы, если их еще нет
                $page = $this->project()->pages()->eq("url", $url)->one();
                if(!$page->exists()) {
                    $page = $this->project()->pages()->create(array(
                        "url" => $url,
                    )); 
                }
                
                // Сохраняем данные в страницу
                $this->data("html", $rawHTML);
                
            }
                        
            
        }
            
    }

}
