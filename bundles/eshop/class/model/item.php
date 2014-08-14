<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель товара
 **/
class Item extends \Infuso\ActiveRecord\Record {

    const STATUS_USER_DISABLED = 1000;
    const STATUS_GROUP_DISABLED = Group::STATUS_USER_DISABLED;
    const STATUS_DETACHED  = Group::STATUS_DETACHED;
    const STATUS_ACTIVE  = Group::STATUS_ACTIVE;

    public static function recordTable() {
        return array(
            'name' => 'eshop_item',
            'fields' => array(
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                    'editable' => '0',
                    'indexEnabled' => '0'
                ), array (
                    'name' => 'priority',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'editable' => '0',
                    'label' => 'Приоритет',
                    'indexEnabled' => '1'
                ), array (
                    'name' => 'title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Название товара',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array (
                    'name' => 'active',
                    'type' => 'checkbox',
                    'editable' => '1',
                    'label' => 'Товар активен',
                ), array (
                    'name' => 'groupId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '1',
                    'label' => 'Группа товаров',
                    'group' => 'Основные',
                    'indexEnabled' => '1',
                    'class' => Group::inspector()->className(),
                ), array (
                    'name' => 'price',
                    'type' => 'nmu2-78a6-tcl6-owus-t4vb',
                    'editable' => '1',
                    'label' => 'Стоимость',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array (
                    'name' => 'description',
                    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
                    'editable' => '1',
                    'label' => 'Описание товара',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array (
                    'name' => 'article',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Артикул',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array (
                    'name' => 'created',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => '2',
                    'label' => 'Дата создания',
                    'group' => 'Дополнительно',
                    'indexEnabled' => '1',
                    "default" => "now()",
                ), array (
    				'name' => 'status',
                    "label" => "Статус",
                    "editable" => 2,
    				'type' => "select",
    				'values' => array(
                        self::STATUS_USER_DISABLED => "Отключен пользователем",
                        self::STATUS_GROUP_DISABLED => "Группа отключена",
                        self::STATUS_DETACHED => "Без родителя",
                        self::STATUS_ACTIVE => "Активен",                        
                    ),
				),
            ),
        );
    }

    /**
     * Видимость класса из браузера
     **/
    public static function indexTest() {
        return true;
    }

    /**
     * Экшн страницы товара
     **/
    public function index_item($p) {
        $item = self::get($p["id"]);
		app()->tm("/eshop/item")->param("item",$item)->exec();
    }

    /**
     * @return Возвращает родительскую группу данного товара
     **/
    public final function recordParent() {
        return $this->group();
    }

    /**
     * @return Возвращает родительскую группу данного товара
     **/
    public final function group() {
        return $this->pdata("groupId");
    }
    
	public function photos() {
	    return ItemPhoto::all()->eq("itemId", $this->id());
	}

    /**
     * Возвращает коллекцию всех товаров, включая скрытые
     **/
    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->addBehaviour("infuso\\eshop\\model\\itemcollection");
    }

    /**
     * Возвращает товар по `id`
     **/
    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }

}
