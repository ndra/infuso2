<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель группы для интернет-магазина
 **/
class Group extends \Infuso\ActiveRecord\Record {

	public static function recordTable() {
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
    				'editable' => '0',
    				'label' => 'Приоритет',
    				'indexEnabled' => '1',
				), array (
    				'name' => 'parent',
    				'type' => 'pg03-cv07-y16t-kli7-fe6x',
    				'editable' => '0',
    				'label' => 'Родительская группа',
       				'indexEnabled' => '1',
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
    				'name' => 'icon',
    				'type' => 'knh9-0kgy-csg9-1nv8-7go9',
    				'editable' => '1',
    				'label' => 'Изображение группы',
    				'group' => 'Основные',
    				'default' => '',
    				'indexEnabled' => '1',
    				'help' => '',
				), array (
    				'name' => 'active',
    				'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
    				'editable' => '1',
    				'label' => 'Активна',
    				'group' => 'Основные',
    				'indexEnabled' => '1',
				), array (
    				'name' => 'description',
    				'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
    				'editable' => '1',
    				'label' => 'Описание',
    				'group' => 'Основные',
    				'indexEnabled' => '0',
				), array (
    				'name' => 'numberOfSubgroups',
    				'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
    				'editable' => '2',
    				'label' => 'Количество подгрупп',
    				'group' => 'Дополнительно',
    				'indexEnabled' => '1',
				), array (
    				'name' => 'numberOfItems',
    				'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
    				'editable' => '2',
    				'label' => 'Количество товаров',
    				'group' => 'Дополнительно',
    				'indexEnabled' => '1',
				),
            ),
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
	    \tmp::param("activeGroupID",$group->id());
	    \tmp::exec("eshop:group", array(
	        "group" => $group,
		));
	}

	/**
	 * @return Возвращает коллекцию активных подгрупп
	 **/
	public function subgroups() {
	    return self::all()->eq("parent",$this->id());
	}

	/**
	 * @return Возвращает коллекцию активных подгрупп всех уровней
	 **/
	public function subgroupsRecursive() {

	    $buf = array();
	    $groups = $this->subgroups()->limit(0);
	    while($groups->count()) {
	        $buf = array_merge($buf,$groups->idList());
	        $groups = self::all()->eq("parent",$groups->idList());
	    }
	    return self::all()->eq("id",$buf);
	}

	/**
	 * @return Возвращает коллекцию товаров в группе, включая скрытые товары
	 **/
	public function items() {
	    $key = "group-".($this->data("depth")+1);
	    return reflex::get("eshop_item")->eq($key,$this->id());
	}

	public function recordParent() {
	    return self::get($this->data("parent"));
	}

	/**
	 * Возвращает группу первого уровня
	 **/
	public function level0() {
	    foreach($this->parents() as $parent) {
	        if(!$parent->parent()->exists()) {
	            return $parent;
	        }
	    }
	    return $this;
	}

	/**
	 * Возвращает группу заданного уровня
	 **/
	public function level($level=0) {
	    foreach($this->parents() as $parent) {
	        if($parent->depth()==$level) {
	            return $parent;
	        }
		}
	    return $this;
	}

	/**
	 * Возвращает глубину группы
	 * Группы верхнего уровня имеют глубину 0
	 **/
	public function depth() {
		return $this->data("depth");
	}

	/**
	 * Возвращает количество товаров в группе, используя сохраненное в таблице число
	 **/
	public function numberOfItems() {
	    return $this->data("numberOfItems");
	}

	/**
	 * Возвращает количество подгрупп, используя сохраненное в таблице число
	 **/
	public function numberOfSubgroups() {
	    return $this->data("numberOfSubgroups");
	}

	public static function all() {
	    return service("ar")
            ->collection(get_class())
            ->asc("priority")
            ->param("sort",true);
	}


	public static function get($id) {
	    return service("ar")->get(get_class(),$id);
	}

}
