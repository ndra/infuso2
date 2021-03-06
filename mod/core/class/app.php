<?

namespace infuso\core;

class App {

	private $post;
	private $get;
	private $files;

	private static $initiated = false;

	/**
	 * Список зарегистрирвоанных служб
	 **/
	private $registerdServices = array();

	/**
	 * Процессор шаблонов приложения
	 **/
	private $templateProcessor = null;

	/**
	 * Текущий экземпляр объекта приложения
	 **/
	private static $current;
	
	/**
	 * url редиректа.
	 **/
	private $redirect = false;

	/**
	 * Возвращает текущий экземпляр объекта приложерия
	 **/
	public function current() {
	    return self::$current;
	}

	public function __construct($params) {
     	//$GLOBALS["infusoStarted"] = microtime(1);
	    $this->url = $params["url"];
	    $this->post = $params["post"];
	    $this->files = $params["files"];
	}

	/**
	 * Подключает жизненно важные классы
	 **/
	public function includeCoreClasses() {

        include("../appfn.php");
	
        include("component.php");
        include("controller/controller.php");	
        include("superadmin.php");
        include("file/flist.php");
		include("profiler.php");		
		include("mod.php"); 		
	    include("service.php");
	    include("classmap/service.php");
	    include("file/file.php");
	    include("file/localfile.php"); 	    
	    include("bundle/bundle.php");
	}

	public function setErrorLevel() {
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
		ini_set("display_errors",1);
	}

	public function configureIni() {
		ini_set('register_globals', 'off');
		ini_set('magic_quotes_gpc', 'off');
		ini_set('magic_quotes_runtime', 'off');
		ini_set('default_charset', "utf-8");
	}

	/**
	 * Коллбэк для загрузки несуществующего класса
	 **/
	public function loadClass($class) {
		$this->service("classmap")->includeClass($class);
	}

	public function init() {
	
	    if(!self::$initiated) {

		    self::$initiated = true;

   			$this->configureIni();
   			$this->setErrorLevel();
			$this->includeCoreClasses();
            $this->createFatalErrorHandler();

			// Регистрируем загрузчик классов
			spl_autoload_register(array($this,"loadClass"));
		}

		$this->registerService("classmap","infuso\\core\\classmapService");
		$this->registerService("route","\\infuso\\core\\route\\service");
		$this->registerService("bundle","\\infuso\\core\\bundle\\manager");
		$this->registerService("yaml","\\infuso\\core\\yaml");
		$this->registerService("cache","\\infuso\\core\\cache\\service");
        $this->registerService("msg","\\infuso\\core\\message\\service");

	}

	/**
	 * Возвращает объект текущего урл
	 **/
	public function url() {
	    return url::get($this->url);
	}

	/**
	 * Возвращаем массив $_POST
	 **/
	public function post() {
	    return $this->post;
	}

	public function files() {
		return $this->files;
	}

	public function action() {
	    if(!$this->action) {
	        $this->action = $this->url()->action();
	    }
	    return $this->action;
	}

	/**
	 * Возвращает текущую запись active record (reflex)
	 **/
	public function ar() {
	    return $this->ar;
	}

    /**
     * Возвращает прощессор щаблонов
     **/         
	public function tm($tmp = null) {
    
        if($tmp) {
            return new \Infuso\Template\Template($tmp);
        }
    
	    if(!$this->templateProcessor) {
	        $this->templateProcessor = new \Infuso\Template\Processor();
        }
                
	    return $this->templateProcessor;
	}

	public function clearTmp() {
	    $this->templateProcessor = null;
	}

	/**
	 * Возвращает флаг того активны ли события приложения
	 * Например, mod_beforeActionSYS или mod_afterActionSys
	 * События приложения выключаются для контроллера infuso\core\console - консоли
	 * т.к. ошибка в стороннем классе может сделать невозможным использование консоли
	 **/
	public function eventsEnabled() {
	    if(preg_match("/^infuso\\\\core\\\\console/i", $this->action()->className())) {
	        return false;
	    }
	    return true;
	}

    /**
     * Запускает приложение
     **/
	public function exec() {

	    ob_start();

	    try {

            // Этот метод делает всю работу, но не обрабатывает исключения
	        $this->execWithoutExceptionHandling();

	    } catch(\Exception $exception) {

            // Пробуем обработать ошибку, показать страницу исключения и т.д
            // Если по каким-то причинам при этом вылетит другое исключение,
            // мы покажем пользователю уже его
		    try {
            
                // Очищаем object buffer
    			while(ob_get_level()) {
    		        ob_end_clean();
    		    }
    
    		    ob_start();
    
				// Сбрасываем процессор шаблонов
		        $this->clearTmp();
                
                // Вызываем событие исключения
                $event = app()->fire("infuso/exception", array(
                    "exception" => $exception,
                ));                

		    } catch(\Exception $ex2) {
		        throw $exception;
		    }

	    }             

        $content = ob_get_clean();
        
        Profiler::SetVariable("content-size", strlen($content));

        // Пост-обработка (отложенные функции)
        if($this->eventsEnabled()) {
	        $event = app()->fire("infuso/afterActionSys",array(
	            "content" => $content,
	        ));
	        $content = $event->param("content");
        }
        
        echo $content;

	}

	public function execWithoutExceptionHandling() {

	    self::$current = $this;
	    $this->init();
	    Profiler::addMilestone("init completed");

	    Header("HTTP/1.0 200 OK");

		// Выполняем post-команду
        if($this->post()["cmd"]) {
            Post::process($this->post(), $this->files());
            Profiler::addMilestone("post completed");
        }

	    Defer::callDeferedFunctions();
	    Profiler::addMilestone("defered functions");
	    
	    if($this->redirect()) {
	        header("Location: ".$this->redirect());
	        die();
		}

		// Выполняем экшн
	    $action = $this->action();

        // Если события не заблокированы - вызываем событие
        if($this->eventsEnabled()) {
        	$this->fire("infuso/beforeActionSYS", array(
                "action" => $this->action(),
            ));
        	Profiler::addMilestone("before action sys");
        	$this->fire("infuso/beforeAction", array(
                "action" => $this->action(),
            ));
        }

	    if($action->exists()) {
			$action->exec();
			Profiler::addMilestone("exec");
	    } else {
			$this->httpError(404);
	    }

	    Defer::callDeferedFunctions();

	}

	public function httpError($code) {
        header("HTTP/1.0 404 Not Found");
        $this->fire("infuso/httperror", array(
            "code" => $code,
        ));
        
	}



	/**
	 * Возвращает массив публичных папок приложения
	 **/
	public function publicFolders() {

	    $ret = array(
	        $this->publicPath(),
		);

		$bundleManager = service("bundle");
	    foreach($bundleManager->all() as $bundle) {
            foreach($bundle->publicFolders() as $pub) {
                $ret[] = $pub;
            }
		}

		return $ret;

	}

    private static $xservices = array();
    
    public function deployer() {
        return new Deploy();
    }

    /**
     * Возвращает службу (объект) по имени службы
     * @todo вернуть назначение класса службам через конфиг
     **/
    public function service($name) {

        $class = $this->registredServices[$name];

        if(!$class) {

            if(!self::$xservices) {
                self::$xservices = $this->service("classmap")->classmap("services");
            }

            $class = self::$xservices[$name];
        }

        if(!$class) {
            throw new \Exception("Service [$name] not found");
        }

        return $class::serviceFactory();
    }

    /**
     * Регистрирует класс в качестве службы
     **/
    public function registerService($service,$class) {
        $this->registredServices[$service] = $class;
    }
    
	/**
	 * Возвращает путь к корню сайта в файловой системе сервера
	 * Используется функциями модуля file для перевода путей ФС в абсолютные
	 **/
	public function root() {
	    return $_SERVER["DOCUMENT_ROOT"]."/";
	}

    /**
     * Возвращает директорию данных приложения
     **/
    public function varPath() {
		return file::get("/var");
    }

    /**
     * Возвращает публичную директорию приложения
     **/
    public function publicPath() {
        return file::get("/pub");
    }

    /**
     * Возвращает конфигигурацию приложения
     **/
    public function confPath() {
        return file::get("/conf");
    }
    
    /**
     * Отправляет пользователю сообщение
     **/         
    public function msg($message, $error = null) {
        service("msg")->msg($message, $error);
    }
    
    /**
     * Записывает сообщение в лог
     **/
    public function trace($message, $type = null) {
    
        if(is_object($message) && is_a($message, "Exception")) {
            $message = array(
                "message" => $_SERVER["REMOTE_ADDR"]." at ".$_SERVER["REQUEST_URI"]." got exception: ".$message->getMessage()." ".var_export($message->getTrace(), true),
                "type" => "error"
            );
        }
    
        if(!is_array($message)) {
            $message = array(
                "message" => $message,
                "type" => $type,
            );
        }
    
        $this->fire("infuso/trace", $message);
    }
    
    public function fire($eventName, $params = array()) {
		$event = new Event($eventName, $params);
        $event->fire();
        return $event;
    }
    
    public function user() {
        return service("user")->active();
    }
    
    /**
     * 1 параметр - перенаправляет прользователя на адрес $url
     * Без параметров - вернет адрес текущего редиректа или null
     **/
	public function redirect($url = null) {
	    if(func_num_args() == 0) {
	        return $this->redirect;
	    } elseif(func_num_args() == 1) {
	        $this->redirect = $url;
	        return $this;
	    }
	    throw new \Exception("app::redirect() wrong arguments number");
	}
    
    public function createFatalErrorHandler() {
    
        register_shutdown_function(function() {
            
            $error = error_get_last();
            
            $errors = array(
                E_ERROR,
                E_PARSE,
                E_CORE_ERROR,
                E_COMPILE_ERROR,
                E_USER_ERROR,
            );
            
            if( $error !== NULL) {
                if(in_array($error["type"], $errors)) {
        		    // Трейсим ошибки
        		    $this->trace(array(
                        "message" => $_SERVER["REMOTE_ADDR"]." at ".$_SERVER["REQUEST_URI"]." got error: ".var_export($error, 1),
                        "type" => "error",
                    )); 
                }
            }
        });        
    }
    
    /**
     * Метод для чтения / записи кук
     **/         
    public function cookie($key = null, $val = null, $keepDays = 30) {
  		if(func_num_args() == 1) {
		    return Cookie::get($key);
		}
		if(func_num_args() == 2 || func_num_args() == 3) {
	    	Cookie::set($key, $val, $keepDays);
	    }
    }
    
    /**
     * Метод для чтения / записи сессии
     **/         
    public function session($key = null, $val = null, $keepDays = 30) {
  		if(func_num_args() == 1) {
		    return Session::get($key);
		}
		if(func_num_args() == 2) {
	    	Session::set($key, $val, $keepDays);
	    }
    }

}
