<?

namespace Infuso\Eshop\Handler;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель корзины (заказа) в интернет-магазине
 **/
class CartEvent extends Core\Event {

    /**
     * Объект товара
     **/         
    private $item = null;
    
    /**
     * Объект корзины
     **/         
    private $cart = null;
    
    /**
     * Объект, который мы будем обновлять
     **/     
    private $itemToUpdate = null;
    
    /**
     * Данные обновляемого/создаваемого объекта
     **/         
    private $cartItemData = array();
    
    public function setItem($itemId) {
        $this->item = Model\Item::get($itemId);
        return $this;
    }
    
    public function item() {
        return $this->item;
    }

    /**
     * Сохраняет объект корзины
     **/       
    public function setCart($cartId) {
        $this->cart = Model\Cart::get($cartId);
        return $this;
    }
    
    /**
     * Возвращает объект корзины
     **/         
    public function cart() {
        return $this->cart;
    }
    
    /**
     * Устанавливает флаг, говорящий о том, что нужно создать новый элемент в товарах заказа
     **/         
    public function create() {
        $this->itemToUpdate = null;
    }
    
    public function isCreate() {
        return ! (bool) $this->itemToUpdate;
    }
    
    /**
     * Устанавливает флаг, говорящий о том, что нужно обновить элемент в товарах заказа.
     * Передает какой именно элемент нужно обновить     
     **/
    public function update($itemToUpdate) {
        $this->itemToUpdate = $itemToUpdate;
    }
    
    public function isUpdate() {
        return (bool) $this->itemToUpdate;
    }
    
    public function quantity() {
        return 1;
    }
    
    public function cartItem() {
        return $this->itemToUpdate;
    }

    /**
     * Метод доступа к данным создаваемой / изменяемой товарной позиции
     **/
    public final function cartItemData($key=null, $val=null) {

        if(func_num_args()==0) {
            return $this->cartItemData;
        }

        if(func_num_args()==1) {

            if(is_array($key)) {
                foreach($key as $a=>$b) {
                    $this->cartItemData($a,$b);
                }
                return $this;
            }

            // Мы возвращаем значение по ссылке
            // Если возвращать по ссылке несуществующие элементы массива, php создает их на лету
            // и записывает в них нули
            // Чтобы этого не произошло - проверяем наличие ключа у массива
            if(array_key_exists($key,$this->cartItemData)) {
                return $this->cartItemData[$key];
            } else {
                return null;
            }

        }

        if(func_num_args()==2) {
            $this->cartItemData[$key] = $val;
            return $this;
        }

    }
    
    /**
     * Метод доступа к данным запроса
     **/
    public final function requestData($key=null, $val=null) {

        if(func_num_args()==0) {
            return $this->requestData;
        }

        if(func_num_args()==1) {

            if(is_array($key)) {
                foreach($key as $a=>$b) {
                    $this->requestData($a,$b);
                }
                return $this;
            }

            // Мы возвращаем значение по ссылке
            // Если возвращать по ссылке несуществующие элементы массива, php создает их на лету
            // и записывает в них нули
            // Чтобы этого не произошло - проверяем наличие ключа у массива
            if(array_key_exists($key,$this->requestData)) {
                return $this->requestData[$key];
            } else {
                return null;
            }

        }

        if(func_num_args()==2) {
            $this->requestData[$key] = $val;
            return $this;
        }

    }

}
