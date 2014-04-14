<?

namespace Infuso\Template;
use Infuso\Core;
use Infuso\Core\File;

/**
 * Класс, склеивающий кусочки файлов css и js
 **/
class Render extends Core\Component {

	private static $less;
	
	private static $renderID = null;
	
	public function initialParams() {
		return array(
			"cache" => true,
		);
	}
	
	private static function lesscssInstance() {
		if(!self::$less) {
			self::$less = new \Lesscss();
		}
		return self::$less;
	}
	
	public static function renderPath() {
	    return Core\Mod::app()->publicPath()."/render/";
	}
	
	/**
	 * Очищает кэш рендера скриптов и стилей
	 **/
	public static function clearRender() {
	    $path = self::renderPath();
	    File::get($path)->delete(true);
	    file::mkdir($path);
	    file::get("{$path}/renderID.txt")->put(\util::id());
	}

	/**
	 * Возвращает ключ рендера для предотвращения кэширования
	 * Он меняется каждый раз при изменении шаблонов из админки
	 **/
	private function renderID() {
	
	    $path = self::renderPath();
	
		if(!self::$renderID) {
		    self::$renderID = file::get("{$path}/renderID.txt")->data();
		    if(!self::$renderID) {
		    	self::$renderID = "*";
			}
		}
		return self::$renderID;
	}
	
	/**
	 * @return bool Включен ли lesscss
	 **/
	public function less() {
		return true;
	}
	
    /**
     * Упаковывает массив css или js файлов в один, сохраняет на диск
     * и возвращает имя сгенерированного файла
     * @todo Сделать отключение кэширваония рендера
     **/
	public function packIncludes($items,$ext) {
	
	    $rpath = self::renderPath();

	    if(is_scalar($items)) {
			return $items;
        }

	    $hash = md5(self::renderID()." - ".serialize($items));
	    $file = file::get("{$rpath}/$hash.$ext");

	    if(!$this->param("cache") || !$file->exists()) {

	        $code = "";
	        foreach($items as $item) {
	            if($str = trim(file::get($item)->data())) {
	            
					$id = \util::id();
					$str = preg_replace("/@bundle/","@bundle-{$id}",$str);
					$str = preg_replace("/@{bundle}/",'@{bundle-'.$id.'}',$str);
	            
					if($ext=="css" && self::less()) {
	                	$code.= '@bundle-'.$id.': "'.(file::get($item)->bundle()->path()).'/";'."\n\n";
	                }
	            
	                // В режиме отладки дописываем источник
	                if(\mod::debug()) {
	                	$code.= "/* source:".$item.": */\n\n";
	                }
	                
	                $code.= $str.($ext=="js" ? "\n;\n" : "\n\n");
	                
				}
			}

			// Если включен lesscss и расширение css - пропускаем через пармер less
			if($ext=="css" && self::less()) {
				$code = self::lesscssInstance()->parse($code);
			}
			
			if(!trim($code)) {
			    return null;
			}

			// Сохраняем результат
		    file::mkdir($file->up(),true);
	        $file->put($code);
	    }

	    return $file."";
	}

}

