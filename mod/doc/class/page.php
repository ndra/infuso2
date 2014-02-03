<?

/**
 * ������ �������� ������������
 **/
class doc_page extends reflex {

    public function reflex_table() {
        return array (
            'name' => get_class(),
            'fields' => array (
                array (
                  'name' => 'id',
                  'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                  'name' => 'title',
                  'type' => 'textfield',
                  'editable' => 1,
                  'label' => '��������',
                ), array (
                  'name' => 'content',
                  'type' => 'textarea',
                  'editable' => 1,
                  'label' => '�������',
                ),
            ),
        );
    }
    
    /**
     * ���������� ��������� ���� ���������
     **/
    public static function all() {
        return reflex::get(get_class())->asc("id");
    }

    /**
     * ���������� ������� �� id
     **/
    public static function get($id) {
        return reflex::get(get_class(),$id);
    }
	
}
