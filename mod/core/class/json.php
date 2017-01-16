<?

namespace Infuso\Core;

/**
 * Контроллер для json-запросов
 **/
class JSON extends \infuso\core\controller {

    public function controller() {
        return "mod_json";
    }

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
                
            // Подменяем массив $_FILES для каждого запроса
            $_FILES = array();
            foreach($xfiles as $key => $file) {
                if(preg_match("/^{$requestId}\//", $key)) {
                    $newKey = preg_replace("/^{$requestId}\//", "", $key);
                    $_FILES[$newKey] = $xfiles[$key];                   
                } 
            }
            
            $results[$requestId] = array(
                "success" => false,
                "messages" => array(),
                "events" => array(), 
            );  

    		try {
            
                ob_start();
                
                // Выполняем крманду
                $result = Post::process(
    				$request,
    				$_FILES,
    				$success
    			);
    
    			// Если скрипт вывел что-нибудь в поток, выводим это как ошибку 			
    			if($txt = ob_get_clean()) {
    				app()->msg($txt, 1);
    			} 
    
    			$results[$requestId]["data"] = $result;
                $results[$requestId]["success"] = true;
                
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
    
    		} catch(Exception\UserLevel $ex) {
            
                // Пользовательская ошибка, ее текст показывать безопасно
                app()->msg($ex->getMessage(), 1);
            
            } catch(\Exception $ex) {
                
    		    // Трейсим ошибки
    		    app()->trace($ex);
                
                // Для суперадмина показывам ошибку целиком
                // Для остальных - просто показываем ошибку
                if(Superadmin::check()) {
                    app()->msg("<b>Exception:</b> ".$ex->getMessage(), 1);
                } else {
                    app()->msg("Exception", 1); 
                }
                
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

		$json = new \mod_confLoader_json();
		echo $json->write($results);
		
	}

}
