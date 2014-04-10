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
                    'name' => 'message',
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
                    'label' => 'Дата платежа',
                    'default' => 'now()',
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

}
