<?

namespace Infuso\Eshop\Controller;
use Infuso\Core;

/**
 * Контроллер для управления заказом
 **/
class Cart extends Core\Controller {

    public function controller() {
        return "cart";
    }

    public function indexTest() {
        return true;
    }
    
    public function postTest() {
        return true;
    }
    
    /**
     * Контроллер добавления товара в корзину
     **/
    public function post_add($p) {
        app()->msg($p);
    }
    
    public function index() {
        app()->tm("/eshop/cart")->exec();
    }

}
