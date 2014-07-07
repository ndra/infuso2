<?

namespace Infuso\Template;
use Infuso\Core;
use Infuso\Core\File;

/**
 * Класс темы оформления
 * Тема представляет собой набор шаблонов.
 * Темы можно подключать и отключать
 **/
abstract class Theme extends Core\Component {

    /**
     * Буффер карт шаблонов
     **/      
	private static $mapBuffer = array();
    
    /**
     * Массив, в котором хранится карта шаблонов темы
     **/         
	private $map = null;
    
    /**
     * Загружает карту шаблонов
     **/         
    public function loadMap() {
    
        if($this->map) {
            return;
        }
    
        $class = get_class($this);
    
		if(!self::$mapBuffer[$class]) {
			$path = self::mapFolder()."/".$class.".php";
			$map = file::get($path)->inc();
	        self::$mapBuffer[$class] = $map;
		}
        
        $this->map = self::$mapBuffer[$class];    
    
    }
    
    public function map() {
        $this->loadMap();
        return $this->map; 
    }

	/**
	 * @return Путь к файлам темы
	 **/
	abstract public function path();

	/**
	 * @return Название темы
	 **/
	abstract public function name();
    
	/**
	 * @return Приоритет темы, по умолчанию 0
	 **/
	public function priority() {
		return 0;
	}

	/**
	 * @return Возвращает путь к файлу темы
	 * Если у темы нет соответствующего файла, возвращает null
	 **/
	public function templateFile($template,$ext) {
		$template = preg_replace("/[\:\.\/]+/","/",$template);
		$template = trim($template,"/");
        $map = $this->map();
		$file = $map[$template][$ext];
		if($file) {
			return file::get($file);
		}
		return file::nonExistent();
	}
	
	/**
	 * Если у темы нет соответствующего файла, возвращает null
	 **/
	public function templateExists($template) {
		self::loadDefaults();
		$template = preg_replace("/[\:\.\/]+/","/",$template);
		$template = trim($template,"/");
		return array_key_exists($template,$this->map());
	}

	/**
	 * @return Возвращает папку, в которую складываются описания шаблонов
	 **/
	public function mapFolder() {
		return Core\Mod::app()->varPath()."/tmp/themes/";
	}
	
	/**
	 * Возвращает папку, в которую будут рендериться php-шаблоны
	 **/
	public function codeRenderFolder() {
	    return Core\Mod::app()->varPath()."/tmp/render-php/";
	}

	/**
	 * @return Возвращает путь к карте данной темы
	 **/
	public function mapFile() {
		return self::mapFolder()."/".get_class($this).".php";
	}

	/**
	 * @return Возвращает корневой шаблон темы
	 **/
	public function base() {
		return "/";
	}

	/**
	 * Возвращает модуль, в котором находится эта тема
	 **/
	public function bundle() {
		return self::inspector()->bundle();
	}

	/**
	 * Должна ли тема подключаться автоматически?
	 **/
	public function autoload() {
		return false;
	}

	/**
	 * Компилирует тему:
	 * Обрабатывает все php-файлы препарсером и сохраняет в папку рендера
	 * Строит карту шаблонов, где имени шаблона соответствует имя файла           
	 **/
	public function compile() {

		$map = array();

        // Ищем все файлы в папке темы
		foreach(file::get($this->path())->search() as $file) {
        
            // Пропускаем папки
            if($file->folder()) {
                continue;
            }

		    if($file->ext()=="php") {
                
                // php-файлы мы обрабатывае препарсером
                // и сохраняем результат в отдельную папку
			    $renderPath = self::codeRenderFolder().$file->path();
			    file::mkdir(file::get($renderPath)->up());
			    $parser = new Preparser();
			    $php = $parser->preparse($file->data());
			    file::get($renderPath)->put($php);
                
		    } else {
            
                // Остальные файлы просто заносим в карту сайта
		        $renderPath = $file."";
		    }

            // Определяем имя шаблона по имени файла
            // Сохраняем данные в карту шаьблонов темы
		    $rel = file::get(file::get($file)->rel($this->path()));
		    $name = $this->base()."/".$rel->up()."/".$rel->basename();
		    $name = trim($name,"/");
		    $name = preg_replace("/[\:\.\/]+/","/",$name);
		    $ext = $file->ext();
		    $map[$name][$ext] = $renderPath;
		    $map[$name]["bundle"] = (string) $file->bundle()->path();
		}

		\util::save_for_inclusion($this->mapFile(),$map);
		
		return $map;
		
	}

	/**
	 * Возвращает шаблон темы относительно имени щшаблона     
	 **/
	public function template($relName) {
		$tmp = new ThemeTemplate($this,$relName);
		return $tmp;
	}
    
    public function templates() {     
        $base = trim($this->base(),"/");     
        $ret = array();
        foreach($this->map() as $name => $templateDescr) {
            $name = substr($name,strlen($base));
            $name = trim($name, "/");
            $ret[] = new ThemeTemplate($this, $name);
        }
        
        return $ret;
        
    }


}
