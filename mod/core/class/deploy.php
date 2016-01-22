<?

namespace Infuso\Core;

class Deploy extends Component implements Handler {

	/**
	 * @handler = infuso/deploy
	 * @handlerPriority = -9999999;
	 **/
	public function onDeploy() {

		app()->msg("Clearing system cache");
		service("cache")->clearByPrefix("system/");

	}
    
	public function generateHtaccess() {
	
		$gatePath = service("classmap")->getClassBundle(get_class())->path()."/pub/gate.php";
		$gatePath = File::get($gatePath);

        // Настройки 
	    $htaccess = $this->param(".htaccess");

	    $htaccess = strtr($htaccess,array('\n'=>"\n"));
		$htaccess.="\n\n";

	    // Создаем .htaccess
	    $str = $htaccess;
	    $str.= "RewriteEngine on \n";
	    $str.= "RewriteCond %{REQUEST_URI} !\. \n";
	    $str.= "RewriteRule .* {$gatePath} [L] \n";

        foreach(app()->publicFolders() as $pub) {
            $pub = "/".trim($pub,"/")."/";
            $pub = strtr($pub,array("/"=>'\/'));
            $str.= "RewriteCond %{REQUEST_URI} !^$pub\n";
        }

		$gatePath2 = strtr($gatePath,array("\\" => "\\/"));
		$str.= "RewriteCond %{REQUEST_URI} !{$gatePath2}\n";
		$str.= "RewriteCond %{REQUEST_URI} !^\/?[^/]*$\n";
		$str.= "RewriteRule .* {$gatePath} [L]\n";

		$str.= "ErrorDocument 404 {$gatePath}\n";

	    File::get(".htaccess")->put($str);
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


}
