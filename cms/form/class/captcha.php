<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Стандартная капча для форм
 **/
class Captcha extends Core\Controller {

    private $publicCode;
    private $privateCode;
    
    private static $sessionKey = "captcha-M2gp7z";
    
    public function __construct($publicCode = null) {
    
		if(func_num_args() == 1) {
			$keys = app()->session(self::$sessionKey);
            if(!$keys) {
                $keys = array();   
            }
            $this->publicCode = $publicCode;
            $this->privateCode = $keys[$this->publicCode];  
		}
    
    }
    
    public function generateCodes() {
        if(!$this->publicCode) {        
            $allowedPublicSymbols = 'abcdefghijklmnopqrstuvwxyz1234567890';
            $allowedPrivateSymbols = "23456789abcdegikpqsvxyz";         
            $this->publicCode = self::randomString($allowedPublicSymbols, 20);
            $this->privateCode = self::randomString($allowedPrivateSymbols, 6);               
            
            $keys = app()->session(self::$sessionKey);
            if(!$keys) {
                $keys = array();   
            }
            $keys[$this->publicCode] = $this->privateCode;
            app()->session(self::$sessionKey, $keys);
        }
    }
    
    public function checkCode($privateCode) {
    	if(!$this->privateCode()) {
    		return false;
		}
		return $privateCode == $this->privateCode();
    }
    
    public static function randomString($alphabet, $length) {
        
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function publicCode() {
        $this->generateCodes();
        return $this->publicCode;
    }

    public function privateCode() {
        $this->generateCodes();
        return $this->privateCode;
    }
    
    public function img() {
    	return \Infuso\Core\Action::get("Infuso\CMS\Form\Controller\Captcha","index",array("code" => $this->publicCode()))->url();
	}

}
