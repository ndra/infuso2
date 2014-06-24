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
    				'name' => 'description',
    				'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
    				'editable' => '1',
    				'label' => 'Описание',
    				'group' => 'Основные',
    				'indexEnabled' => '0',
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
	    app()->tmp("eshop:group")
            ->param("group", $group)
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
	public function items() {
	    return service("ar")
            ->collection(Item::inspector()->className())
            ->eq("groupId",$this->id());
	}

	public function recordParent() {
	    return self::get($this->data("parent"));
	}

	public static function all() {
	    return service("ar")
            ->collection(get_class())
            ->asc("priority");
	}


	public static function get($id) {
	    return service("ar")->get(get_class(),$id);
	}

}
