<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель группы для интернет-магазина
 **/
class Group extends \Infuso\ActiveRecord\Record implements \Infuso\Cms\Search\Searchable {

    const STATUS_VOID = 0;
    const STATUS_USER_DISABLED = 1;
    const STATUS_DETACHED = 2;
    const STATUS_ACTIVE = 3;

	public static function model() {
        return array (
      		'name' => 'eshop_group',
      		'fields' => array (
			    array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'label' => 'Первичный ключ',
					'indexEnabled' => '0',
				), array (
					'name' => 'depth',
					'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
					'editable' => '0',
					'label' => 'Глубина',
					'indexEnabled' => '1',
				), array (
    				'name' => 'priority',
    				'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
    				'label' => 'Приоритет',
    				'indexEnabled' => '1',
				), array (
    				'name' => 'parent',
    				'type' => 'pg03-cv07-y16t-kli7-fe6x',
    				'label' => 'Родительская группа',
       				'indexEnabled' => '1',
                    "editable" => true,
    				'class' => self::inspector()->className(),
				), array (
    				'name' => 'title',
    				'type' => 'v324-89xr-24nk-0z30-r243',
    				'editable' => '1',
    				'label' => 'Название группы товаров',
    				'group' => 'Основные',
    				'indexEnabled' => '1',
    				'help' => 'Название товарной группы',
				), array (
    				'name' => 'description',
    				'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
    				'editable' => '1',
    				'label' => 'Описание',
    				'indexEnabled' => '0',
				), array (
    				'name' => 'active',
    				'type' => 'checkbox',
    				'editable' => '1',
    				'label' => 'Активна',
    				"default" => 1,
				), array (
    				'name' => 'status',
    				'type' => "select",
                    "label" => "Статус",
                    "editable" => 2,
    				'values' => self::enumStatuses(),
				), array (
    				'name' => 'numberOfItems',
    				'type' => "bigint",
                    'editable' => 2,
                    "label" => "Количество активных товаров",
				),
            ),
        );
    }
    
    public function enumStatuses() {
        return array(
            self::STATUS_ACTIVE => "Активна", 
            self::STATUS_VOID => "Пустая",
            self::STATUS_USER_DISABLED => "Отключена пользователем",
            self::STATUS_DETACHED => "Без родителя",                                   
        );
    }

	public function controller() {
	    return "eshop-group";
	}

	public static function indexTest() {
	    return true;
	}

	/**
	 * Контроллер страницы группы
	 **/
	public static function index_item($p) {
	    $group  = self::get($p["id"]);
	    app()->tm("eshop:group")
            ->param("group", $group)
            ->param("queryParams", $p)
            ->exec();
	}

	/**
	 * @return Возвращает коллекцию активных подгрупп
	 **/
	public function subgroups() {
	    return self::all()->eq("parent",$this->id());
	}

	/**
	 * @return Возвращает коллекцию товаров в группе, включая скрытые товары
	 **/
	public function _items() {
	    return service("ar")
            ->collection(Item::inspector()->className())
			->param("sort", true)
            ->eq("groupId",$this->id());
	}
    
    /**
     * Возвращает товары в самой группе и в подгруппах
     **/         
    public function _itemsRecursive() {
    
        $id = array();
        
        $scan = function($group) use (&$id, &$scan, &$n) {
        
            if(in_array($group->id(), $id)) {
                return;
            }
        
            $id[] = $group->id();
            foreach($group->subgroups() as $subgroup) {
                $scan($subgroup);
            }            
        };
        
        $scan($this);
        
        return Item::all()->eq("groupId", $id);    
    }

	/**
	 * Возвращает родителя - родительскую группу
	 **/
	public function recordParent() {
	    return self::get($this->data("parent"));
	}

	/**
	 * Возвращает коллекцию всех групп
	 **/
	public static function all() {
	    return service("ar")
            ->collection(get_class())
            ->asc("priority")
            ->addBehaviour("infuso\\eshop\\model\\groupcollection");
	}

	/**
	 * Возвращает группу по id
	 **/
	public static function get($id) {
	    return service("ar")->get(get_class(),$id);
	}
	
	/**
	 * Возвращает количество товаров
	 **/
	public function numberOfItems() {
	    return $this->items()->count();
	}
    
    public function searchContent() {
    }
}
