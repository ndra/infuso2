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

	private static $buffer = array();
	private static $defaultsLoaded = null;
	private $descr = null;

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
	 * @return Возвращает тему по имени класса
	 * @todo какая-то хуета, не пойму вобще зачем это
	 **/
	public function get($class) {
		if(!self::$buffer[$class]) {
			$path = self::mapFolder()."/".$class.".php";
			$descr = file::get($path)->inc();
			$theme = new $class;
			$theme->setDescr($descr);
	        self::$buffer[$class] = $theme;
		}
		return self::$buffer[$class];
	}

	public function setDescr($descr) {
		$this->descr = $descr;
	}

	/**
	 * @return Возвращает путь к файлу темы
	 * Если у темы нет соответствующего файла, возвращает null
	 **/
	public function templateFile($template,$ext) {
		$template = preg_replace("/[\:\.\/]+/","/",$template);
		$template = trim($template,"/");
		$file = $this->descr[$template][$ext];
		if($file) {
			return file::get($file);
		}
		return file::nonExistent();
	}

	/**
	 * @return Возвращает путь к файлу темы
	 * Если у темы нет соответствующего файла, возвращает null
	 **/
	public function templateExists($template) {
		self::loadDefaults();
		$template = preg_replace("/[\:\.\/]+/","/",$template);
		$template = trim($template,"/");
		return array_key_exists($template,$this->descr);
	}

	/**
	 * @return Возвращает папку, в которую складываются описания шаблонов
	 **/
	public function mapFolder() {
		return Core\Mod::app()->varPath()."/tmp/themes/";
	}
	
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
	 * @return Возвращает параметры для конструктора данной темы
	 **/
	public function constructorParams() {
		return null;
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
	 * Сохраняет описние и структуру файлов темы в файл
	 **/
	public function buildMap() {

		$map = array();

		foreach(file::get($this->path())->search() as $file) {

		    if($file->ext()=="php") {
			    $renderPath = self::codeRenderFolder().$file->path();
			    file::mkdir(file::get($renderPath)->up());
			    $parser = new Preparser();
			    $php = $parser->preparse($file->data());
			    file::get($renderPath)->put($php);
		    } else {
		        $renderPath = $file."";
		    }

		    $rel = file::get(file::get($file)->rel($this->path()));
		    $name = $this->base()."/".$rel->up()."/".$rel->basename();
		    $name = trim($name,"/");
		    $name = preg_replace("/[\:\.\/]+/","/",$name);
		    $ext = $file->ext();
		    $map[$name][$ext] = $renderPath;
		}

		\util::save_for_inclusion($this->mapFile(),$map);
		
		return $map;
		
	}

	/**
	 * @return class tmp_theme_template (не путать с tmp_template)
	 **/
	public function template($path="/") {
		$tmp = new \tmp_theme_template($this,$path);
		return $tmp;
	}

	/**
	 * @return Массив со всеми шаблонами темы
	 **/
	public function templates() {
		$ret = array();
		foreach($this->descr as $path => $tdesr) {
		    $ret[] = new \tmp_theme_template($this,$path);
		}
		return $ret;
	}
	
	/**
	 * @return Массив со всеми шаблонами темы
	 **/
	public function templatesArray() {
		return $this->descr;
	}

	/**
	 * Загружает дефолтные темы
	 **/
	public function loadDefaults() {
	
	    if(self::$defaultsLoaded) {
	        return;
	    }
		self::$defaultsLoaded = true;
		
		foreach(Core\File::get(self::mapFolder()."/_autoload.php")->inc() as $key => $val) {
            Tmp::$templateMap[$key] = $val;
		}
	}

}
