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
     	$GLOBALS["infusoStarted"] = microtime(1);
	    $this->url = $params["url"];
	    $this->post = $params["post"];
	    $this->files = $params["files"];
	}

	/**
	 * Подключает жизненно важные классы
	 **/
	public function includeCoreClasses() {

        include("../appfn.php");
	
		include("profiler.php");
		include("component.php");
		include("mod.php");
		
		Profiler::beginOperation("core","includeCoreClasses",1);
	    include("controller/controller.php");
	    include("superadmin.php");
	    include("service.php");
	    include("classmap/service.php");
	    include("file/file.php");
	    include("file/localfile.php");
	    include("file/flist.php");
	    include("bundle/bundle.php");
	    Profiler::endOperation();
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
	    if(preg_match("/^infuso\\\\core\\\\console/i",$this->action()->className())) {
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

	        $this->execWithoutExceptionHandling();

	    } catch(\Exception $exception) {

			while(ob_get_level()) {
		        ob_end_clean();
		    }

		    ob_start();

		    // Трейсим ошибки
		    $this->trace(array(
                "message" => $_SERVER["REMOTE_ADDR"]." at ".$_SERVER["REQUEST_URI"]." got exception: ".$exception->getMessage(),
                "type" => "error"
            ));

		    try {

				// Сбрасываем процессор шаблонов
		        $this->clearTmp();

			    $this->tm("/mod/exception")
                    ->param("exception", $exception)
                    ->exec();

		    } catch(\Exception $ex2) {
		        throw $exception;
		    }

	    }

        $content = ob_get_clean();

        // Пост-обработка (отложенные функции)
        if($this->eventsEnabled()) {
	        $event = app()->fire("infusoAfterActionSys",array(
	            "content" => $content,
	        ));
	        $content = $event->param("content");
        }

        echo $content;

        app()->fire("infusoAppShutdown");

	}

	public function execWithoutExceptionHandling() {

	    self::$current = $this;
	    $this->init();
	    Profiler::addMilestone("init completed");

	    Header("HTTP/1.0 200 OK");

		// Выполняем post-команду
	    Post::process($this->post(),$this->files());
	    Profiler::addMilestone("post completed");

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

	public function httpError() {
        header("HTTP/1.0 404 Not Found");
		$this->tm("/mod/404")->exec();
	}

	public function generateHtaccess() {
	
		$gatePath = service("classmap")->getClassBundle(get_class())->path()."/pub/gate.php";
		$gatePath = file::get($gatePath);

	    // Загружаем xml с настройками
	    //$htaccess = mod::conf("mod:htaccess");
	    $htaccess = "";

	    $htaccess = strtr($htaccess,array('\n'=>"\n"));
		$htaccess.="\n\n";

		/*if(mod::conf("mod:htaccess-non-www"))
			$htaccess.="
RewriteCond %{HTTPS} off
RewriteCond %{REQUEST_METHOD} !=POST
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ http://%1/$1 [R=301,L]

RewriteCond %{HTTPS} on
RewriteCond %{REQUEST_METHOD} !=POST
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]\n\n
	"; */

	    // Создаем .htaccess
	    $str = $htaccess;
	    $str.="RewriteEngine on \n";
	    $str.="RewriteCond %{REQUEST_URI} !\. \n";
	    $str.="RewriteRule .* {$gatePath} [L] \n";

        foreach($this->publicFolders() as $pub) {
            $pub = "/".trim($pub,"/")."/";
            $pub = strtr($pub,array("/"=>'\/'));
            $str.= "RewriteCond %{REQUEST_URI} !^$pub\n";
        }

		$gatePath2 = strtr($gatePath,array("\\" => "\\/"));
		$str.= "RewriteCond %{REQUEST_URI} !{$gatePath2}\n";
		$str.= "RewriteCond %{REQUEST_URI} !^\/?[^/]*$\n";
		$str.= "RewriteRule .* {$gatePath} [L]\n";

		$str.= "ErrorDocument 404 {$gatePath}\n";

	    file::get(".htaccess")->put($str);
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

    /**
     * Один шаг инсталляции приложения
     * Вернет true, если инициализация на этом шаге закончилась
     **/
    public function deployStep($step) {
    
		if($step==0) {
			$this->generateHtaccess();
			classmap\builder::buildClassMap();
		    $next = true;
		} else {
			$event = new Event("infuso/deploy");
			$done = !$event->firePartial($step - 1);
		}

        return $done;

    }

    /**
     * Инсталлирует приложение
     **/
    public function deploy() {

        set_time_limit(0);

        $n = 0;
        do {
            $done = app()->deployStep($n);
            $n++;
        } while (!$done);

    }

    private static $xservices = array();

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
    
        if(!is_array($message)) {
            $message = array(
                "message" => $message,
                "type" => $type,
            );
        }
    
        $this->fire("infuso/trace", $message);
    }
    
    public function fire($eventName, $params = array()) {
        if($this->eventsSuspended) {
            return;
        }
		$event = new Event($eventName, $params);
		$event->fire();
        return $event;
    }
    
    public function user() {
        return \user::active();
    }
    
    public function suspendEvents() {
        $this->eventsSuspended = true;
    }
    
	public function unsuspendEvents() {
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
        
            $errfile = "unknown file";
            $errstr  = "shutdown";
            $errno   = E_CORE_ERROR;
            $errline = 0;
            
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
            
                    $errno   = $error["type"];
                    $errfile = $error["file"];
                    $errline = $error["line"];
                    $errstr  = $error["message"];
                    $this->trace(var_export($error,1), "error");
                
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
		if(func_num_args() == 2) {
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
