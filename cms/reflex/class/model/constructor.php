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
	
	public static function model() {
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
        return service("ar")->collection(get_class())->desc("created");
    }
    
    public static function get($data) {
        return service("ar")->get(get_class(),$data);
    }
    
    public function beforeCreate() {
        $this->data("userID", app()->user()->id());
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
    
    /**
     * Создает элемент из конструктора и возвращает его редактор
     **/         
    public function createItem($data) {
    
        // Создаем элемент
        $item = $this->collection()->collection()->create($data);
        
        // Создаем объект редактора
        $class = get_class($this->collection()->editor());
        $editor = new $class($item->id());
        
        // Копируем файлы из папки хранилища
        foreach($editor->item()->fields() as $field) {
            if($field->typeID() == "knh9-0kgy-csg9-1nv8-7go9") {
                $val = $field->value();
                $folder = "/".trim($this->storage()->root(), "/");
                $folder = preg_quote($folder, "/");
                if(preg_match("/^$folder/", $val)) {
                    $newFile = $item->storage()->add($val, basename($val));
                    $field->value($newFile);
                } 
            }
        }
        
        return $editor;
    }
    
}
