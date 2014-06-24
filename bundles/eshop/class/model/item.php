<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель товара
 **/
class Item extends \Infuso\ActiveRecord\Record {

    public static function recordTable() {
        return array(
            'name' => 'eshop_item',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                    'editable' => '0',
                    'indexEnabled' => '0'
                ), array(
                    'name' => 'priority',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'editable' => '0',
                    'label' => 'Приоритет',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Название товара',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'groupId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '1',
                    'label' => 'Группа товаров',
                    'group' => 'Основные',
                    'indexEnabled' => '1',
                    'class' => Group::inspector()->className(),
                ), array(
                    'name' => 'price',
                    'type' => 'nmu2-78a6-tcl6-owus-t4vb',
                    'editable' => '1',
                    'label' => 'Стоимость',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'description',
                    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
                    'editable' => '1',
                    'label' => 'Описание товара',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'article',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Артикул',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'created',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => '2',
                    'label' => 'Дата создания',
                    'group' => 'Дополнительно',
                    'indexEnabled' => '1'
                )
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
        \tmp::exec("/eshop/item", array(
            "item" => $item
        ));
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

    /**
     * Возвращает коллекцию всех товаров, включая скрытые
     **/
    public static function all() {
        return service("ar")->collection(get_class());
    }

    /**
     * Возвращает товар по `id`
     **/
    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }

}
