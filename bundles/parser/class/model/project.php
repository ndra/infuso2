<?

namespace Infuso\Parser\Model;
use Infuso\Core;

class Project extends \Infuso\ActiveRecord\Record {

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
                ),
            ),
        );
    }

    /**
     * Возвращает список всех проектов
     **/
    public static function all() {
        return service("ar")->collection(get_class());
    }

    /**
     * Возвращает проект по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public function pages() {
        return Page::all()->eq("projectId", $this->id());
    }
    
    public function parseStep() {
        if($this->pages()->void()) {
        
            // Если в проекте нет страниц, создаем первую
            $this->pages()->create(array(
                "url" => $this->data("url"),
            ));
        } else {
        
            // Выбираем первую страницу с незаполненным HTML
            $page = $this->pages()->eq("html", "")->one();
            if($page->exists()) {
                $page->parse();
            }
        
        }
    }

}
