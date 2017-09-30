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
                    'type' => 'string',
                    'editable' => 1,
                    'length' => 500,
                ), array (
                    'name' => 'html',
                    'label' => "HTML",
                    'type' => 'html',
                    'editable' => 2,
                ), array (
                    'name' => 'projectId',
                    'label' => "Проект",
                    'type' => 'link',
                    "class" => Project::inspector()->className(),
                    'editable' => 2,
                ), array (
                    'name' => 'depth',
                    'label' => "Глубина",
                    'type' => 'bigint',
                    "class" => Project::inspector()->className(),
                    'editable' => 1,
                ), array (
                    'name' => 'status',
                    'label' => "Статус",
                    'type' => 'select',
                    'values' => array(
                        0 => "Новый",
                        1 => "Скачано",
                        2 => "Ошибка",
                    ),
                    'editable' => 1,
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
    
    /**
     * Подготавливает урл к загрузке
     * Удаляет лишние параметры
     **/
    public function prepareURL($url) {
    
        $url = new \Infuso\Core\Url($url);
        $url->hash("");
        
        // Урл проекта        
        $projectURL = new \Infuso\Core\Url($this->project()->data("url"));
        
        // Разбираемся со ссылками от корня сайта (без http://domain.com)
        if(!$url->scheme()) {
            $url->domain($projectURL->domain());
            $url->scheme($projectURL->scheme());
        }
        
        if(!in_array($url->scheme(), array("http", "https"))) {
            return false;
        }
        
        if(strpos((String)$url, (String)$projectURL) !== 0) {
            return false;
        }       
        
        // Убираем параметры из строки запроса
        foreach($url->query() as $key => $val) {
            $url->query($key, null);
        }
        
        return $url;
    
    }
    
    public function parse() {
    
        echo $this->data("url"); 
        
        try {
        
            $rawHTML = Core\File::http($this->data("url"))->contents();         
            $html = new \Infuso\Parser\HTML($rawHTML);
            
            // Проходимся по всем ссылкам
            foreach($html->xpath("//a") as $a) {     
                    
                if($url = $this->prepareURL($a->attr("href"))) {     
                    
                    // Добавляем страницы, если их еще нет
                    $page = $this->project()->pages()->eq("url", $url)->one();
                    if(!$page->exists()) {
                        $page = $this->project()->pages()->create(array(
                            "url" => $url,
                            "depth" => $this->data("depth") + 1,
                        )); 
                    }                
                }
            }
                    
            // Сохраняем данные в страницу
            
            $rawHTML = \Infuso\Util\Util::str($rawHTML)->decode();
            
            $this->data("html", $rawHTML);
            $this->data("status", 1);
        
        } catch (\Exception $ex) {
            $this->data("status", 2);
        } 
            
    }

}
