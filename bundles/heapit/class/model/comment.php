<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class Comment extends \Infuso\ActiveRecord\Record {

    public static function recordTable() {
        return array(
            'name' => 'heapitComment',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array(
                    'name' => 'text',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Сообщение',
                ), array(
                    'name' => 'author',
                    'type' => 'link',
                    'class' => \user::inspector()->className(),
                    'label' => 'Ползователь',
                ), array(
                    'name' => 'datetime',
                    'type' => 'datetime',
                    'editable' => '1',
                    'label' => 'Дата написания',
                    'default' => 'now()',
                ), array(
                    'name' => 'parent',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Родитель',
                ),
             ),
        );
    }
    
    public static function all() {
        return \reflex::get(get_class())->desc("datetime");
    }
    
    public static function get($id) {
        return Core\Mod::service("ar")->get(get_class(),$id);
    }   
    
    public function afterCreate() {
        $this->bargain()->handleComment();
    }
    
    public function bargain() {
        list($type,$id) = explode(":", $this->data("parent"));
        if($type === "bargain") {
        	return Bargain::get($id);
        }
        return Bargain::get(0);
    }

}
