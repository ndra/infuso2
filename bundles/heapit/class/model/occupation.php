<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

/**
 * Класс, описывающий соотрудников котнрагентов
 * эту сущность также называют 'Контактное лицо'
 **/
class Occupation extends \Infuso\ActiveRecord\Record {
    
    public static function model() {
        return array(
            'name' => 'heapitOccupation',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ),  array(
                    'name' => 'orgId',
                    'type' => 'link',
                    'editable' => '1',
                    'class' => '\\Infuso\\Heapit\\Model\\Org',
                    'label' => 'Организация',
                ), array(
                    'name' => 'occId',
                    'type' => 'link',
                    'editable' => '1',
                    'class' => '\\Infuso\\Heapit\\Model\\Org',
                    'label' => 'Id сотрудника',
                ),
             ),
        );
    }
    
    public static function all() {
        return service("ar")->collection(get_class());
    }
    
    
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public static function indexTest() {
        return true;
    }                 
}
