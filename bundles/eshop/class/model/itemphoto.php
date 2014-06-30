<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель фотографии товара
 **/
class ItemPhoto extends \Infuso\ActiveRecord\Record {

    public static function recordTable() {
        return array(
            'name' => 'eshop_item_photo',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array(
                    'name' => 'itemId',
                    'type' => 'link',
                    'class' => Item::inspector()->className(),
                    "editable" => 1,
                    'label' => 'Товар',
                ), array(
                    'name' => 'priority',
                    'type' => 'bigint',
                    'editable' => true,
                    'label' => 'Приоритет',
                ), array(
                    'name' => 'photo',
                    'type' => 'file',
                    'editable' => true,
                    'label' => 'Фотография',
                ),
            ),
        );
    }

    /**
     * @return Возвращает родительскую группу данного товара
     **/
    public final function recordParent() {
        return $this->item();
    }

    /**
     * @return Возвращает родительскую группу данного товара
     **/
    public final function item() {
        return $this->pdata("itemId");
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
