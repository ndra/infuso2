<?

namespace Infuso\Board\Model;

class TagDescription extends \Infuso\ActiveRecord\Record {

    public static function recordTable() {

        return array (
            'name' => 'board_task_tag_description',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => 1,
                    'label' => 'Название',
                ),
            ),
        );
    }

    public static function all() {
        return \Infuso\ActiveRecord\Record::get(get_class())->asc("title");
    }

    public static function get($id) {
        return \Infuso\ActiveRecord\Record::get(get_class(),$id);
    }

}
