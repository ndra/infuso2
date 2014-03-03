<?

/**
 * Модель корневого элемента в каталоге
 **/
class reflex_editor_root extends reflex {

    

	public static function recordTable() {
		return array (
			'name' => 'reflex_editor_root',
			'fields' => array (
				array (
					'id' => 'ku6n8vrjy9hqp9hopaiqk9b38v6tke',
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'editable' => '0',
					'indexEnabled' => '0',
				), array (
					'id' => '6jclh78g0xparqylho85sqf9b7wg2t',
					'name' => 'group',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '0',
					'indexEnabled' => '1',
				), array (
					'id' => '6tmu0jwlsx8li7cgr3yg0jfu6q4l2t',
					'name' => 'parent',
					'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
					'editable' => '0',
					'indexEnabled' => '1',
				), array (
					'id' => 'mv0x85homa6d8ab741bopv0xk52nc9',
					'name' => 'title',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '0',
					'indexEnabled' => '1',
				), array (
					'id' => '0qyg63p96n4e6jme078erxw527cahq',
					'name' => 'data',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'editable' => '0',
					'label' => 'Данные списка',
					'indexEnabled' => '1',
				), array (
				'id' => 'j450twgr34ainmv0tpuhdpgz74lrq8',
				'name' => 'created',
				'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
				'editable' => '2',
				'indexEnabled' => '1',
				), array (
				'editable' => 2,
				'id' => 'gznw503curtcgit4u0tf10dpabtce0',
				'name' => 'priority',
				'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
				'label' => 'Приоритет',
				'group' => '',
				'default' => '',
				'indexEnabled' => 1,
				'help' => '',
				), array (
				'editable' => 2,
				'id' => '5rdf9rq8v0nkehnfl0jcvstwu2t8e0',
				'name' => 'tab',
				'type' => 'v324-89xr-24nk-0z30-r243',
				'label' => '',
				'group' => '',
				'default' => '',
				'indexEnabled' => 1,
				'help' => '',
				'length' => '',
),
	  ),
	);
	}

	public static function all() {
        return reflex::get(get_class());
    }

    public static function get($id) {
        return reflex::get(get_class(),$id);
    }
    
    public function reflex_children() {

        if($this->data("data")) {
            return array($this->getList());
        }
            
        return array();
    }

    public function getList() {
        return \Infuso\ActiveRecord\Collection::unserialize($this->data("data"));
    }

    public function reflex_cleanup() {
        // Удаляем руты которым больше суток
        if(util::now()->stamp() - $this->pdata("created")->stamp() > 3600*24) return true;
    }

    public function reflex_beforeCreate() {
        $this->data("created",util::now());
    }


}
