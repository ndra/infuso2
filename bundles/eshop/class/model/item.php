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
                    'name' => 'parent',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '1',
                    'label' => 'Группа товаров',
                    'group' => 'Основные',
                    'indexEnabled' => '1',
                    'class' => 'eshop_group'
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
                    'name' => 'photos',
                    'type' => 'f927-wl0n-410x-4grx-pg0o',
                    'editable' => '1',
                    'label' => 'Фотографии',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'active',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'editable' => '1',
                    'label' => 'Активный',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'starred',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'editable' => '1',
                    'label' => 'Избранный',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'instock',
                    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                    'editable' => '1',
                    'label' => 'В наличии (шт)',
                    'group' => 'Основные',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'order',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'editable' => '1',
                    'label' => 'Возможность заказа',
                    'group' => 'Основные',
                    'indexEnabled' => '1',
                    'help' => 'Установка этого чекбокса разрешает заказывать товар, даже если его нет в наличии'
                ), array(
                    'name' => 'activeSys',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'editable' => '0',
                    'label' => 'Активна ли группа',
                    'indexEnabled' => '1'
                ), array(
                    'name' => 'vendor',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '1',
                    'label' => 'Производитель',
                    'group' => 'Основные',
                    'indexEnabled' => '1',
                    'class' => 'eshop_vendor'
                ), array(
                    'name' => 'model',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Модель',
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
                    'name' => 'extra',
                    'type' => 'puhj-w9sn-c10t-85bt-8e67',
                    'editable' => '1',
                    'label' => 'Дополнительно',
                    'group' => 'Дополнительно',
                    'indexEnabled' => '0'
                ), array(
                    'name' => 'created',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => '2',
                    'label' => 'Дата создания',
                    'group' => 'Дополнительно',
                    'indexEnabled' => '1'
                )
            ), 'indexes' => array(
                array (
                    'name' => 'title-f',
                    'fields' => 'title',
                    'type' => 'fulltext'
                ), array(
                    'name' => 'a-p-s',
                    'fields' => 'activeSys,priority,starred',
                    'type' => 'index'
                )
            )
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
    public static function index_item($p) {
        $item = self::get($p["id"]);
        tmp::exec("/eshop/item", array(
            "p1" => $item,
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
        return $this->pdata("parent");
    }

    /**
     * @return Возвращает коллекцию групп для данного товара
     **/
    public function groups()
    {
        $idList = array();
        foreach ($this->parents() as $parent)
            $idList[] = $parent->id();
        return eshop_group::allEvenHidden()->eq("id", $idList)->desc("depth");
    }

    /**
     * @return Возвращает производителя товара
     **/
    public function vendor() {
        return $this->pdata("vendor");
    }

    /**
     * Возвращает коллекцию всех товаров, включая скрытые
     **/
    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->param("sort", true);
    }

    /**
     * Возвращает товар по `id`
     **/
    public static function get($id) {
        return reflex::get(get_class(), $id);
    }

    public function photos() {

        $fn  = "photos";
        $ret = array();
        foreach (array_reverse($this->behaviours()) as $b) {
            if (method_exists($b, $fn)) {
                $items = call_user_func(array(
                    $b,
                    $fn
                ));
                foreach ($items as $item) {
                    $ret[] = $item;
                }
            }
        }

        if (!sizeof($ret)) {
            if ($nophoto = $this->nophoto()) {
                $ret[] = $nophoto;
            }
        }

        return new file_list($ret);
    }

    /**
     * @return bool добавлен ли товар в корзину?
     **/
    public function inCart() {
        foreach (eshop_order::cart()->items() as $item) {
            if ($item->item()->id() == $this->id()) {
                return true;
            }
        }
    }

}
