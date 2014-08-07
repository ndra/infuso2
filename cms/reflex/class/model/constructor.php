<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель конструктора
 * Конструктор - это специальный элемент, который создается пр нажатии кнопки "+"
 * Форма создания элемента - это фактически форма редактирования конструктора  
 **/ 
class Constructor extends ActiveRecord\Record {
	
	public static function recordTable() {
		return array (
			'name' => 'reflex_editor_constructor',
			'fields' => array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
				), array (
					'id' => 'yainkl2tfg2tw563y5h3y5so856dm1',
					'name' => 'title',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '2',
					'indexEnabled' => '1',
				), array (
					'editable' => 2,
					'name' => 'userID',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Пользователь',
					'indexEnabled' => 1,
					'class' => 'user',
				), array (
					'name' => 'created',
					'type' => 'ler9-032r-c4t8-9739-e203',
					"default" => "now()",
					'editable' => '2',
					'label' => 'Дата создания',
					'indexEnabled' => '1',
				), array (
					'name' => 'collection',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'editable' => '2',
					'label' => 'Данные списка',
				), array (
					'name' => 'redirect',
					'type' => 'string',
				),
			),
		);
	}

    public static function all() {
        return reflex::get(get_class())->desc("created");
    }
    
    public static function get($data) {
        return reflex::get(get_class(),$data);
    }
    
    public function beforeCreate() {
        $this->data("userID",\user::active()->id());
    }
    
    public function collection() {
        return Reflex\Collection::unserialize($this->data("collection"));
    }
    
    public function recordTitle() {
        return "Новый объект ".get_class($this->collection()->editor()->item());
    }
    
    public function recordParent() {
        return $this->collection()->editor()->item()->parent();
    }
    
    public function createItem($data) {
        $item = $this->collection()->collection()->create($data);
        $class = get_class($this->collection()->editor());
        $editor = new $class($item->id());
        return $editor;
    }
    
}
