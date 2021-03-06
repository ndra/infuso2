<?

namespace Infuso\Eshop\Model;
use Infuso\User\Model\User as User;
use Infuso\Core;

/**
 * Модель корзины (заказа) в интернет-магазине
 **/
class Cart extends \Infuso\ActiveRecord\Record {

	const STATUS_DRAFT = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_COMPLETED = 2;
	const STATUS_CANCELLED = 3;

    /**
     * Имя куки с ключами моих заказов
     **/
    private static $cookieMyOrders = "fubqw5rd";
    
    public function indexTest($p) {
        $cart = self::get($p["id"]);
        if(!$cart->my()) {
            return false;
        }
        return true;
    }
    
	public function index_item($p) {
	    $cart = self::get($p["id"]);
	    app()->tm("/eshop/order")
	        ->param("order", $cart)
			->param("cart", $cart)
			->exec();
    }
    
	public function controller() {
	    return "order";
    }
    
	public static function model() {
        $data = array (
      		'name' => 'eshop_cart',
      		'fields' => array (
			    array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'label' => 'Первичный ключ',
					'indexEnabled' => '0',
				), array (
					'name' => 'security',
					'type' => 'string',
					'label' => 'Секретный код',
					'editable' => 0,
				), array (
					'name' => 'status',
					'type' => 'select',
					'label' => 'Статус',
					'values' => self::statusList(),
					'editable' => 1,
				), array (
					'name' => 'submitDatetime',
					'type' => 'datetime',
					'label' => 'Дата и время отправки',
					'editable' => 2,
				), array(
                    "name" => "userId",
                    "type" => "pg03-cv07-y16t-kli7-fe6x",
                    "label" => "Пользователь",
                    'class' => "Infuso\\User\\Model\\User",
                    "editable" => 2, 
                ),
            ),
        );
        
        foreach(self::submitFields() as $field) {
            $data["fields"][] = $field;
		}
		
		// Создаем сценарий submit на основе полей из self::submitFields()
		$data["scenarios"]["submit"]["fields"] = array();
		foreach(self::submitFields() as $field) {
		    $data["scenarios"]["submit"]["fields"][] = array(
		        "name" => $field["name"],
		        "editable" => 1,
			);
		}

        return $data;
    }
    
    /**
     * Возвращает список статусов заказа
     * Этот метод можно переопределить поведением
     **/
    public static function _statusList() {
        return array(
            self::STATUS_ACTIVE => "Активный",
            self::STATUS_DRAFT => "Черновик",
            self::STATUS_COMPLETED => "Завершен",
            self::STATUS_CANCELLED => "Отменен",
		);
    }
    
    public static function _submitFields() {
        return array(
            array(
                "name" => "firstName",
                "type" => "string",
                "label" => "Имя",
                "min" => 3,
                "editable" => 1,
			), array(
                "name" => "lastName",
                "type" => "string",
                "label" => "Фамилия",
                "min" => 3,
                "editable" => 1,
			), array(
                "name" => "email",
                "type" => "string",
                "label" => "Электронная почта",
                "min" => 3,
                "editable" => 1,
			), array(
                "name" => "phone",
                "type" => "string",
                "label" => "Телефон",
                "min" => 6,
                "editable" => 1,
			), array(
                "name" => "city",
                "type" => "string",
                "label" => "Город",
                "min" => 3,
                "editable" => 1,
			), array(
                "name" => "building",
                "type" => "string",
                "label" => "Дом",
                "min" => 1,
                "editable" => 1,
			), array(
                "name" => "flat",
                "type" => "string",
                "label" => "Квартира",
                "editable" => 1,
			),
		);
    }

	public static function all() {
	    return service("ar")
            ->collection(get_class())
			->desc("submitDatetime");
	}
    
	public static function drafts() {
	    return service("ar")
            ->collection(get_class())
			->eq("status", self::STATUS_DRAFT);
	}

	public static function get($id) {
	    return service("ar")->get(get_class(),$id);
	}
    
    public function beforeCreate() {
        $this->data("security", \util::id());
    }
    
    /**
     * Возвращает все заказы пользователя
     **/
    public function myOrders() {
        $user = app()->user();
        if($user->exists()) {
            $ret = self::all()->eq("userId", $user->id());
        } else {
            $s = \util::splitAndTrim(app()->cookie(self::$cookieMyOrders), ",");
            $ret = self::all()->eq("security", $s);
        }
        return $ret;
    }

    /**
     * Возвращает пользователя, сделавшего заказ
     **/
    public function user() {
        $user = user::get($this->data("userId"));
        if(!$user->exists()) {
            $user = user::virtual(array(
                "email" => $this->data("email"),
            ));
        }
        return $user;
    }

    /**
     * Вернет активный заказ (Корзину)
     **/
    public static function active() {
       
        $cart = self::myOrders()
            ->eq("status", self::STATUS_DRAFT)
            ->desc("id")
            ->one();
       
        if(!$cart->exists()) {
            $cart = new Cart();
        }
        
        return $cart;
    }
    
    /**
     * Возвращает true/fasle, в зависимости от того, принадлежит ли данный заказ активному пользователю
     **/
    public function my() {
    
        $user = app()->user();
        if($user->exists() && $user->id() == $this->data("userId")) {
            return true;
        }
        
        $s = \util::splitAndTrim(app()->cookie(self::$cookieMyOrders), ",");
        if(in_array($this->data("security"), $s)) {
            return true;
        }
        
        return false;
    }

    /**
     * Создает новый заказ
     * Прикрепляет его текущему пользователю
     **/
    public static final function createCartForActiveUser() {
    
        $cart = service("ar")->create(get_class(),array(
            "userId" => app()->user()->id(),
        ));

        $cart->store();
        $cart->addToCookies();  
        return $cart;
    }

    /**
     * Записываем секретный ключ заказа в список 'мойх заказов'
     **/
    public function addToCookies() {
        $order = $this;
        $s = \util::splitAndTrim(app()->cookie(self::$cookieMyOrders), ",");
        $s[] = $order->data("security");
        $s = array_unique($s);
        $s = implode(",", $s);
        app()->cookie(self::$cookieMyOrders, $s);        
    }


   /**
     * Возвращает активную корзину, если корзитны нет, создает ее
     **/
    public function getActiveCreateIfNotExists() {
        $cart = self::active();
        if(!$cart->exists()) {
            $cart = self::createCartForActiveUser();
        }
        return $cart;
    }
    
    /**
     * Возвращает элементы в засаде
     **/         
    public function items() {
        return CartItem::all()->eq("cartId", $this->id())->limit(0);
    }

    /**
     * Возвращает сумму заказа
     **/
	public function total() {   	
	    $ret = 0; 	    
	    foreach($this->items()->limit(0) as $item) {
	        $ret += $item->totalPrice();
	    }       	    
	    return $ret; 	
	}
	
	/**
     * Дублирует ранее созданный заказ
     **/
	public function _repeatOrder() {
        $oldOrder = $this;
		
		//получаем доступные для покупки товары из прошлого заказа
        $itemsForCart = $oldOrder->activeItems();
        if(!$itemsForCart->count()){
            app()->msg("Нет доступных для заказа товаров", 1);
            return false;
        }
        
        // Получаем активную корзину
        $cart = \Infuso\Eshop\Model\Cart::active();
        
        // Очищаем корзину
        $cart->items()->delete();
        
        // Если нет корзины, создаем
        $cart = self::getActiveCreateIfNotExists();  
        
        // Перебираем товары из старого заказа
        foreach($itemsForCart as $item) {
			$event = new \Infuso\Eshop\Handler\CartEvent("eshop/add");
			$event->requestData("id", $item->item()->id());
			$event->requestData("quantity", $item->quantity());
			$event->setItem($item->item()->id());
			$event->fire();
        }
        app()->msg("Заказ добавлен в корзину"); 
    }
    
    /**
     * Возвращаем доступные для заказа товары
     **/
    public function _activeItems() {
        $itemsForOrder = $this->items()->joinByField("itemId")->eq("Infuso\\Eshop\\Model\\Item.active",1);
        return $itemsForOrder;    
    }

}
