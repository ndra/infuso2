<?

namespace Infuso\Core\File;
use Infuso\Core;

/**
 * Класс для работы с внешними файлами
 **/
class Http extends Core\File {

    private $lastCurl = null;
    
    private $responseHeaders = null;

    public function initialParams() {
        return array(
            "curlOptions" => array(),
            "timeout" => 30,
        );
    }

    public function __construct($path) {
        $this->path = $path;
    }
    
	/**
	 * @return striung Возвращает имя файла (без пути)
	 **/
	public function name() {
	    $name = explode("/", trim($this->path(), "/"));
	    return end($name);
	}
    
    public function userAgent($ua) {
        $options = $this->param("curlOptions");
        $options["CURLOPT_USERAGENT"] = $ua;
        $this->param("curlOptions",$options);
    }
    
    public function curlParam($key, $val) {
        $options = $this->param("curlOptions");
        $options[$key] = $val;
        $this->param("curlOptions",$options);
        return $this;
    }

    public function getRedirect($n = 20) {
    
        $url = $this."";

        while(1) {
    
	        $ch = $this->getCurl();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$a = curl_exec($ch);
			
			preg_match('/^location: (.*)/im', $a, $r);
			$redirect = trim($r[1]);
			
			preg_match('/^http\/[\d\.]+ (\d+)/im', $a, $r);
			$code = trim($r[1]);

			if($redirect && in_array($code,array(301,302))) {
			    $url = $redirect;
			} else {
			    return $url;
			}
			
			$n--;
			
			if($n<=0) {
			    return $url;
			}
		
		}
    }
    
    public function timeout($timeout = 0) {
        if(func_num_args() == 0) {
            return $this->param("timeout");
        } elseif (func_num_args() == 1) {
            return $this->param("timeout", $timeout);
            return $this;
        }
    }

    /**
     * Возвращает ресурс curl c базовыми настройкми
     **/
    private function getCurl() {

        $ch = curl_init($this->path());

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->param("timeout"));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->param("timeout"));
        
        foreach($this->param("curlOptions") as $key => $val) {
            curl_setopt($ch, constant($key), $val);
        }

        $this->lastCurl = $ch;

        return $ch;
    }

    /**
     * Возвращает содержимое внешнего файла
     * Если попытка скачивания не удалась, выбрасывает исключение
     * @todo добавить curl_close()
     **/
    public function contents() {

        Core\Profiler::beginOperation("file", "http-contents", $this->path());

        $ch = $this->getCurl();
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        $response = curl_exec($ch);
        
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->responseHeaders = substr($response, 0, $headerSize);
		$body = substr($response, $headerSize);
        
        if($error = $this->errorText()) {
            throw new \Exception($error." ".var_export($this->info(), true));
        }

        $info = $this->info();        
        if($info["http_code"] != 200) {
            throw new \Exception("Request failed code ".$info["http_code"]." ".var_export($this->info(), true));
        }
        
        Core\Profiler::endOperation();
        return $body;
    }
    
    /**
     * Копирует удаленный файл в папку $dest
     **/
    public function copy($dest) {
    
        $ch = $this->getCurl();
        curl_setopt($ch, CURLOPT_HEADER, false);
        
        $out = fopen(\Infuso\Core\File::get($dest)->native(), "wb");
        if ($out == FALSE){ 
          print "File not opened<br>"; 
          exit; 
        } 

        curl_setopt($ch, CURLOPT_FILE, $out);
        
        curl_exec($ch);
        
        if($error = $this->errorText()) {
            throw new \Exception($error." ".var_export($this->info(), true));
        }
        
    }

    /**
     * Возвращает полный путь к файлу
     **/
    public function native() {
        return $this->path();
    }

    /**
     * Проверяет наличие внешнего файла
     **/
    public function exists() {
        $ch = $this->getCurl();          
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);      
        $connectable = curl_exec($ch);
        curl_close($ch);
        return $connectable;
    }

    public function info() {
        return curl_getInfo($this->lastCurl);
    }
    
    public function responseHeaders() {
        return $this->responseHeaders;
	}

    public function errorText() {
        return curl_error($this->lastCurl);
    }

}
