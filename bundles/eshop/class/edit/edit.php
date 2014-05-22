<?

/**
 * Контроллер для изменения статуса заказа
 **/
class eshop_edit extends mod_controller {

	public static function postTest() {
		return user::active()->checkAccess("admin:showInterface");
	}

	public static function post_getStatuses($p) {
	
		if(!user::active()->checkAccess("eshop:getOrderStatusList")) {
		    app()->msg("У вас нет прав для изменения статуса заказа",1);
		    return;
		}
	
		$order = eshop::order($p["orderID"]);
		
	    $ret = array();
	    
	    $ret["status"] = $order->data("status");
	    
	    foreach(eshop_order_status::all() as $status)
	        $ret["data"][] = array(
	            "id" => get_class($status),
	            "text" => $status->name()
	        );
	        
	    return $ret;
	}

	public static function post_changeStatus($p) {
	
		if(!user::active()->checkAccess("eshop:changeOrderStatus")) {
		    app()->msg("У вас нет прав для изменения статуса заказа",1);
		    return;
		}
		
	    $order = eshop_order::get($p["orderID"]);
	    $order->setStatus($p["status"]);
	    
	    app()->msg("Статус заказа изменен");
	    
	    return true;
	}

}
