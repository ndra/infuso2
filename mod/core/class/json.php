<?

/**
 * Контроллер для json-запросов
 **/
class mod_json extends \infuso\core\controller {

	public function indexTest() {
	    return true;
	}
	
	public function index() {

		header("Content-type: text/plain; charset=utf-8");
        
		$data = $_POST["data"];
		$data = json_decode($data,1);
        $results = array();      
        $xfiles = $_FILES;        
        
        // Обрабатываем пачку команд
        foreach($data["requests"] as $requestId => $request) {
                
            $_FILES = array();
            foreach($xfiles as $key => $file) {
                if(preg_match("/^{$requestId}\//", $key)) {
                    $newKey = preg_replace("/^{$requestId}\//", "", $key);
                    $_FILES[$newKey] = $xfiles[$key];                   
                } 
            }

    		try {
            
                ob_start();
                
                $result = \infuso\core\post::process(
    				$request,
    				$_FILES,
    				$success
    			);
    
    			// Если скрипт вывел что-нибудь в поток, выводим это как ошибку 			
    			if($txt = ob_get_clean()) {
    				app()->msg($txt, 1);
    			} 
    
    			$results[$requestId] = array(
                    "data" => $result,
                    "success" => $success,
                    "messages" => array(),
                    "events" => array(), 
                );                  
                
                \Infuso\Core\Defer::callDeferedFunctions();  
                
        		// Собираем массив событий
        		$events = array();
        		foreach(\Infuso\Core\Event::all() as $event) {
        			$results[$requestId]["events"][] = array(
        				"name" => $event->name(),
        				"params" => $event->params()
        			);
        		}
                
                \Infuso\Core\Event::clearFiredEvents(); 
    
    		} catch(Exception $ex) {
                
    		    // Трейсим ошибки
    		    app()->trace($ex);
                app()->msg("<b>Exception:</b> ".$ex->getMessage(), 1);
                
    		}
            
    		// Собираем массив сообщений
    		$messages = array();
    		foreach(service("msg")->messages() as $msg) {
    			$results[$requestId]["messages"][] = array(
    				"text" => $msg->text(),
    				"error" => $msg->error(),
    			);
    		}
            
            service("msg")->clear();
            
        }

		$json = new mod_confLoader_json();
		echo $json->write($results);
		
	}

}
