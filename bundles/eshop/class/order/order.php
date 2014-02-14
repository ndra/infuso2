<?

use Infuso\Core;

/**
 * Модель заказа (он же модель корзины)
 **/
class eshop_order extends reflex implements mod_handler {

    

public static function reflex_table() {return array (
  'name' => 'eshop_order',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'lst8eiqme0tfvsqpastyurdf50dmuh',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '2',
      'label' => 'Номер заказа',
      'group' => 'Основное',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    1 => 
    array (
      'id' => 'qp5iqy5zxwesq41rd8as7w12tc9bdp',
      'name' => 'sent',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Заказ отправлен',
      'group' => 'Основное',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    2 => 
    array (
      'id' => 'pv6j81sn4ls7f90xw903merocu23ce',
      'name' => 'name',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Имя клиента',
      'group' => 'Основное',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    3 => 
    array (
      'id' => 'stm56xkestpv2t4ezom1rdp9itp5s7',
      'name' => 'phone',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'телефон',
      'group' => 'Основное',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    4 => 
    array (
      'id' => 'c9z741zdyv0okgb3p10dyvztc12jke',
      'name' => 'email',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Адрес электронной почты',
      'group' => 'Основное',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    5 => 
    array (
      'id' => 'erjflrnmusdyaztmlhdkgsqpe6ncab',
      'name' => 'comments',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => '1',
      'label' => 'Комментарии к заказу',
      'group' => 'Основное',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    6 => 
    array (
      'id' => 'wit79cnuwkd9s1ehdrki36x9guzu2a',
      'name' => 'postcode',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Почтовый индекс',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    7 => 
    array (
      'id' => '453dj8ldo291liqyzxoymrmhe0klsv',
      'name' => 'city',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Город',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    8 => 
    array (
      'id' => '8pr5utc9qo07op3ntbc6tmcl9dsf2t',
      'name' => 'country',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Страна',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    9 => 
    array (
      'id' => 'hlfutsiz2xwcwwcde5dhzqp3q9xd6q',
      'name' => 'street',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Улица',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    10 => 
    array (
      'id' => '0zrw9rqsmvf3kr9mxmxwu6n7x57y9y',
      'name' => 'house',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Дом',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    11 => 
    array (
      'id' => 'evslw8ry6k13f3t0v3psgnf1l6b3sv',
      'name' => 'building',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Строение',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    12 => 
    array (
      'id' => 'sp3d328vu8eztihrfblftkkbiwvk15',
      'name' => 'flat',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Квартира/офис',
      'group' => 'Доставка',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    13 => 
    array (
      'id' => 'rqwuin896qmustwezo850781idcgb7',
      'name' => 'userID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '2',
      'label' => 'Пользователь',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'user',
      'collection' => '',
      'titleMethod' => '',
    ),
    14 => 
    array (
      'id' => 'cqwnh0udw28ju4uo8f1sdmfig7xese',
      'name' => 'status',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '2',
      'label' => 'Сатус заказа',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    15 => 
    array (
      'id' => 'okuh3kl2xcl0345zxwlidpuin4vzdm',
      'name' => 'total',
      'type' => 'nmu2-78a6-tcl6-owus-t4vb',
      'editable' => '2',
      'label' => 'Общая сумма',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    16 => 
    array (
      'id' => 'd85rnmein850nku07f96nm10jmgidw',
      'name' => 'security',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '0',
      'label' => 'security code',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '',
    ),
    17 => 
    array (
      'id' => 'sxfe6qmv2qplzo4g6xkasnm5zn8v6q',
      'name' => 'created',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Дата создания',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    18 => 
    array (
      'id' => '2jces34e678uhx8e0d8lzj8vsj41sd',
      'name' => 'changed',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Дата изменения',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    19 => 
    array (
      'id' => 'f927wl0n410x4grxpg0opli3cgixca',
      'name' => 'session',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '0',
      'label' => 'Сессия',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'stat_session',
      'collection' => '',
      'titleMethod' => '',
    ),
  ),
  'indexes' => 
  array (
  ),
);}

/**
     * Видимость для браузеров
     **/
    public static function indexTest() {
        return true;
    }

    /**
     * Контроллер корзины (перенаправляет на страницу заказа)
     **/
    public static function index() {
        $url = eshop_order::cart()->url();
        header("location:$url");
        die();
    }

    /**
     * Контроллер страницы заказа
     **/
    public static function index_item($p) {
        $order = self::get($p["id"]);
        if(!$order->my())
            mod_cmd::error(404);
        tmp::exec("eshop:order",$order,$p);
    }

    /**
     * Обновляет итоговую сумму заказа
     **/
    public final function updateTotal() {
        $this->data("total",$this->total());
    }

    public final function reflex_beforeCreate() {
        $this->data("created",util::now());
        $this->data("security",util::id());
    }

    public final function reflex_beforeOperation() {
        $this->data("changed",util::now());
    }

    public function on_eshop_cartContentChanged($p) {

        $cart = $p->param("cart");
        $cart->updateTotal();
        $cart->data("changed",util::now());

        mod::fire("eshop_cartChanged",array(
            "order" => $this,
            "cart" => $this,
            "deliverToClient" => true,
        ));

    }

    /**
     * Возвращает true/fasle, в зависимости от того, принадлежит ли данный заказ активному пользователю
     **/
    public function my() {
        $user = user::active();
        if($user->exists() && $user->id() == $this->data("userID")) return true;
        $s = util::splitAndTrim($_COOKIE[self::$cookieMyOrders],",");
        if(in_array($this->data("security"),$s)) return true;
        return false;
    }

    /**
     * Возвращает true/fasle, в зависимости от того, может ли пользователь редактировать данный заказ
     * Редактировать можно новый заказ (тот которому еще не присвоен статус) + заказ должен
     * быть "своим", т.е. создан текущим пользователем.
    **/
    public function editable() {
        if(!$this->my())
            return false;
        if($this->data("status"))
            return false;
        return true;
    }

    /**
     * Возвращает все заказы пользователя
     **/
    public function myOrders() {
        $user = user::active();
        if($user->exists()) {
            $ret = self::all()->eq("userID",$user->id());
        } else {
            $s = util::splitAndTrim($_COOKIE[self::$cookieMyOrders],",");
            $ret = self::all()->eq("security",$s);
        }
        return $ret;
    }

    /**
     * Возвращает пользователя, сделавшего заказ
     **/
    public function user() {
        $user = user::get($this->data("userID"));
        if(!$user->exists()) {
            $user = reflex::virtual("user",array(
                "email" => $this->data("email"),
            ));
        }
        return $user;
    }

    public static function on_mod_beforeAction() {
    
        $user = user::active();
        
        if(!$user->exists()) {
            return;
        }
            
        $s = util::splitAndTrim($_COOKIE[self::$cookieMyOrders],",");
        
        foreach($s as $id) {
            reflex::get(get_class())->eq("security",$id)->eq("userID",0)->one()->data("userID",$user->id());
		}
		
        setcookie(self::$cookieMyOrders,false,-1,"/");
        
        
    }

    private static $cookie = "orderID";
    private static $cookieMyOrders = "fubqw5rd";

    /**
     * Изменяет статус заказа
     **/
    public final function setStatus($status) {

        $statusObj = eshop_order_status::get($status);

        if(!$statusObj->exists())
            return false;

        if($statusObj->beforeSet($this)===false)
            return;

        if($this->draft()) {
            $this->fixItems();
            $this->data("sent",util::now());
        }

        $this->data("status",$status);
        $this->log("Статус изменен на «{$statusObj->title()}»");

        $statusObj->afterSet($this);

        mod::fire("eshop_orderStatusChanged",array(
            "order" => $this,
            "status" => $status,
            "deliverToClient" => true,
        ));
    }


    /**
     * Вернет активный заказ (Корзину)
     **/
    public static function cart() {
        $id = $_COOKIE[self::$cookie];
        $order = Core\Mod::service("ar")->virtual(get_class());
        if($id)
            $order = eshop_order::drafts()->eq("id",$id)->one();
        if(!$order->my())
            $order = Core\Mod::service("ar")->virtual(get_class());
        return $order;
    }

    /**
     * Создает новый заказ
     * Прикрепляет его текущему пользователю
     **/
    public static final function createOrderForActiveUser() {
        $order = self::create(get_class(),array(
            "userID" => user::active()->id(),
        ));

        $id = $order->id();
        setcookie(self::$cookie,$id,time()+60*60*24*30,"/");
        $_COOKIE[self::$cookie] = $id;

        $order->addToCookies();

        return $order;
    }

    /**
     * Записываем секретный ключ заказа в список 'мойх заказов'
     **/
    public function addToCookies() {

        $order = $this;
        $s = util::splitAndTrim($_COOKIE[self::$cookieMyOrders],",");
        $s[] = $order->data("security");
        $s = array_unique($s);
        $s = implode(",",$s);
        setcookie(self::$cookieMyOrders,$s,time()+60*60*24*30,"/");
        $_COOKIE[self::$cookieMyOrders] = $s;
    }

    /**
     * Создает новый пустой заказ на основе данного
     * Копируются все поля заказа, но не товары в нем
     **/
    public function duplicateEmpty() {

        $order = self::create(get_class($this),$this->data());

        if($this->my())
            $order->addToCookies();

        return $order;
    }

    /**
     * Возвращает коллекцию товаров данного заказа
     **/
    public function items() {
        $ret = eshop_order_item::all()->eq("orderID",$this->id())->limit(0);
        if(!$this->exists()) $ret->eq("id",-1);
        return $ret;
    }

    /**
     * Добавляет $n товаров с id = $itemID в данный зазаз
     * @return class eshop_order_item добавленный элемент
     **/
    public function addItem($itemID,$n = 1, $itemSku = null) {

        if($n<=0)
            reflex::virtual("eshop_order_item");
        
        $items = $this->items();
        $items->eq("itemID", $itemID);
        if ($itemSku) {
            $items->eq("itemSku", $itemSku);
        }
        
       
        $item = $items->one();
        
        
        if(!$item->exists())
            $item = reflex::create("eshop_order_item",array(
                "orderID" => $this->id(),
                "itemID" => $itemID,
                "itemSku" => $itemSku,
            ));
            
        $item->setQuantity($item->quantity()+$n);

        mod::fire("eshop_addToCart",array(
            "cart" => $this,
            "itemID" => $itemID,
            "item" => $item,
            "itemSku" => $itemSku,
            "quantity" => $n,
            "deliverToClient" => true,
        ));
        
        return $item;
        
    }

    /**
     * Уменьшить количество товаров на $n
     * @param $integer $itemID ID товарной позиции
     * @param $integer $n На сколько надо уменьшить количество
     * Если количество товаров в позиции получится <=0, эта позиция удаляется из заказа
     **/
    public function decreaseItem($itemID,$n=1) {

        if($n<=0)
            return;

        $item = $this->items()->eq("itemID",$itemID)->one();
        if(!$item->exists())
            return;

        $quantity = $item->quantity()-$n;
        if($quantity<=0)
            $item->delete();
        else
            $item->setQuantity($quantity);
    }

    /**
     * Добавляет в заказ $n товаров $itemID
     * Если товар в таким itemID существует, меняет его количество
     * Если $n=0, удаляет позицию
     **/
    public function setQuantity($itemID,$n=1) {

        $item = $this->items()->eq("itemID",$itemID)->one();
        if($n>0) {
            if(!$item->exists())
                $item = reflex::create("eshop_order_item",array(
                    "orderID" => $this->id(),
                    "itemID" => $itemID
                ));
                $item->setQuantity($n);
        } else {
            $item = $this->items()->eq("itemID",$itemID)->one()->delete();
        }

    }

    /**
     * Возвращает полную стоимость заказа
     **/
    public function total() {
        $total = 0;
        foreach($this->items() as $item)
            $total += $item->data("quantity")*$item->price();
        return $total;
    }

    /**
     * @return Возвращает суммарное количество товаров в заказе
    **/
    public function totalNumber() {
        $total = 0;
        foreach($this->items() as $item)
            $total += $item->data("quantity");
        return $total;
    }

    /**
     * Возвращает сообщение для пользователя о статусе заказа (поле `message` класса eshop_order_status)
    **/
    public function message() {
        $ret = trim($this->status()->descr());
        if(!$ret)
            $ret = $this->status()->title();
        return $ret;
    }

    /**
     * Очищает данный заказ
     * @return $this
     **/
    public function clear() {
        $this->items()->delete();
    }

    /**
     * Возвращает объект статуса заказа
     **/
    public function status() {
        return eshop_order_status::get($this->data("status"));
    }

    /**
     * @return true/false в зависимости от того черновик это или нет
     **/
    public function draft() {
        return !$this->data("status");
    }

    /**
     * Фиксирует цену и название у товаров в заказе
     * Метод вызывается в момент отправки заказа
     **/
    public function fixItems() {
        foreach($this->items() as $item)
            $item->fixItem();
    }

    /**
     * Возвращает коллекцию всех заказов
     **/
    public static function all() {
        return reflex::get(get_class())->desc("sent")->neq("status","");
    }

    /**
     * Возвращает коллекцию всех черновиков (неоформленных заказов)
     **/
    public static function drafts() {
        return reflex::get(get_class())->desc("created")->eq("status","");
    }

    /**
     * Возвращает заказ по ID
     **/
    public static function get($id) {
        return reflex::get(get_class(),$id);
    }

    /**
     * Возвращает дату заказа
     * Для отправленых заказов дата заказа - дата отправки
     * Для неотправленных заказов дата заказа - дата создания
     **/
    public function date() {
        return $this->draft() ? $this->pdata("changed") : $this->pdata("sent");
    }

    /**
     * @return Массив дочерних элементов для каталога
     **/
    public function reflex_children() {
        return array(
            $this->items()->title("Состав заказа"),
        );
    }

    /**
     * Отделяет от заказа те товары, которые есть в наличии
     * Создает новый заказ с этими товарами
     * Товары, которых нет в наличии остаются в текущем заказе
     **/
    public function detachInstockItems() {
        $order = $this->duplicateEmpty();
        foreach($this->items() as $item) {
            
            // Расчитываем сколько элементов в наличии мы можем перебросить в новый заказ
            $n = min($item->item()->inStock(),$item->quantity());
            
            // Добавляем в новый заказ элементы которые в наличии из текущего заказа
            if($n>0) {
                $itemID = $item->item()->id();
                $item2 = $order->addItem($itemID,$n);
                $item2->data("price",$item->data("price"));
                $item2->data("title",$item->data("title"));
                $this->decreaseItem($itemID,$n);
            }
        }
        
        return $order;
    }

    /**
     * @return true/false в зависимости от того, в наличии ли ВСЕ товары в заказе в достаточном количестве
     **/
    public function allInStock() {
        foreach($this->items() as $item){
            if($item->item()->data("instock") < $item->data("quantity"))
                return false;
        }
        return true;
    }
    
    /**
     * @return bool
     * Возвращает true если в заказе есть как товары в наличии так и не в наличии
     **/
    public function partiallyInStock() {

        // Если в наличии 0 товаров, возвращаем false,
        // т.к. нам нужен именно «смешанный» заказ
        if($this->instockNumber()==0)
            return false;

        // Если какого-то товара в наличии меньше чем в заказе, возвращаем true
        foreach($this->items() as $item) {
            if($item->item()->data("instock") < $item->data("quantity"))
                return true;
        }

        // Если мы дошли до этого момента, все товары в наличии. Возвращаем false
        return false;
    }

    /**
     * Количество товаров из данного заказа, которе есть в наличии
     **/
    public function instockNumber() {
        $n = 0;
        foreach($this->items() as $item){
            $n+= min($item->item()->inStock(),$item->quantity());
        }
        return $n;
    }

}
