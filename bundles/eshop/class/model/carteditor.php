<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class CartEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Cart::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = eshop
	 **/
	public function orders() {
	    return Cart::all()
			->title("Заказы");
	}
    
    public function templateEditBeforeForm() {
        return app()->tm("/eshop/admin/cart-items")
            ->param("editor", $this);    
    }
    
    public function listItemtemplate() {
        return app()->tm("/eshop/admin/cart-list-item")
			->param("editor", $this);
    }
    
    /**
     * Возвращает массив фильтров для коллекции заказов.
     * Фильтры соответствуют статусам заказа
     **/
    public function filters($collection) {
        $ret = array();
        foreach(Cart::statusList() as $status => $name) {
            $ret[$name] = $collection->copy()->eq("status", $status);
        }
        return $ret;
    }
    
}
