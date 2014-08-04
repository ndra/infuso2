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
        $n = 0;
        foreach($data["requests"] as $request) {
        
            $_FILES = array();
            foreach($xfiles as $key => $file) {
                if(preg_match("/^{$n}\//",$key)) {
                    $newKey = preg_replace("/^{$n}\//", "", $key);
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
    
    			$results[$n] = array(
                    "data" => $result,
                    "success" => $success 
                );
    
    			// Если скрипт вывел что-нибудь в поток, выводим это как сообщение 			
    			if($txt = ob_get_clean()) {
    				app()->msg($txt,1);
    			}  
                
                \Infuso\Core\Defer::callDeferedFunctions();   
    
    		} catch(Exception $ex) { 
    			app()->msg("<b>Exception:</b> ".$ex->getMessage(),1);
    		}
            
            $n++;
            
        }

		// Собираем массив сообщений
		$messages = array();
		foreach(service("msg")->messages() as $msg) {
			$messages[] = array(
				"text" => $msg->text(),
				"error" => $msg->error(),
			);
		}

		// Собираем массив событий
		$events = array();
		foreach(\infuso\core\event::all() as $event) {
			$events[] = array(
				"name" => $event->name(),
				"params" => $event->params()
			);
		}

		$ret = array(
			"messages" => $messages,
			"events" => $events,
			"results" => $results,
		);


		$json = new mod_confLoader_json();
		echo $json->write($ret);
		
	}

}
