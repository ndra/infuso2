<?

namespace infuso\ActiveRecord;
use \Infuso\Core;

/**
 * Класс-файловое хранилище для ActiveRecord
 **/
class Storage extends \Infuso\Core\Controller {

	private $class;
	private $id;
	private $path;

	public function __construct($class=null,$id=null,$path="/") {
	    $this->class = $class;
	    $this->id = $id;
	    $this->path = $path;
	}

	public function setPath($path) {
	    $this->path = $path;
        return $this;
	}

	public function relPath() {
	    return $this->path;
	}

	/**
	 * Возвращает id записи ActiveRecord, с которой связан этот экземпляр хранилища
	 **/
	public function id() {
		return $this->id;
	}

	public function record() {
		return Record::get($this->class,$this->id);
	}

	public function defaultFolder() {
	    $c = explode("_",$this->class);
	    $mod = $c[0];
	    $class = strtr($this->class,array("\\" => "_"));
	    return \mod::app()->publicPath()."/files/{$class}/";
	}

	public function root() {
	    $ret = $this->record()->recordStorageFolder();
	    if(!$ret) {
	        $ret = $this->defaultFolder();
	    }

        $key = $this->record()->id();
        $primaryKeyPrefix = substr(md5($key),0,2);
        $ret.= "/$primaryKeyPrefix/$key/";

	    return $ret;
	}

	public function path() {
	    $path = $this->root()."/".$this->path."/";
	    return $path;
	}

	public function exists() {
	    if(!$this->record()->exists()) {
			return false;
		}
	    return true;
	}

	/**
	 * Создает папку хранилища и помещает в нее файл описания
	 **/
	public function prepareFolder() {
	    if(!$this->exists()) {
			return;
		}
	    $path = $this->root();
	    Core\File::mkdir($path);
	    // Добавляем описание в папку хранилища
	    Core\File::get("$path/storage.descr")->put("{$this->class}:{$this->id()}");
	}

	/**
	 * Возвращает список файлов в хранилище
	 **/
	public function files() {
	    if(!$this->exists()) {
			return \Infuso\Core\FList::void();
		}
	    return Core\File::get($this->path())->dir()->exclude("storage.descr")->sort();
	}

	/**
	 * Возвращает список всех файлов в хранилище, включая те что во вложенных папках
	 **/
	public function allFiles() {
	    if(!$this->exists()) {
			return Core\FList::void();
		}
	    return Core\File::get($this->root())->search()->exclude("storage.descr");
	}

	/**
	 * Возвращает размер файлов в хранилище
	 **/
	public function size() {
		return $this->allFiles()->size();
	}

	public function count() {
	    return $this->allFiles()->files()->length();
	}

	public static function normalizeName($str) {

	    $str = mb_strtolower($str,"utf-8");
	    $tr = array(
	        "й" => "y",
	        "ц" => "ts",
	        "у" => "u",
	        "к" => "k",
	        "е" => "e",
	        "н" => "n",
	        "г" => "g",
	        "ш" => "sh",
	        "щ" => "sh",
	        "з" => "z",
	        "х" => "h",
	        "ъ" => "",
	        "ф" => "f",
	        "ы" => "i",
	        "в" => "v",
	        "а" => "a",
	        "п" => "p",
	        "р" => "r",
	        "о" => "o",
	        "л" => "l",
	        "д" => "d",
	        "ж" => "zh",
	        "э" => "e",
	        "я" => "ya",
	        "ч" => "ch",
	        "с" => "s",
	        "м" => "m",
	        "и" => "i",
	        "т" => "t",
	        "ь" => "",
	        "б" => "b",
	        "ю" => "yu",
	    );
	    $str = strtr($str,$tr);
	    $str = preg_replace("/[^1234567890qwertyuiopasdfghjklzxcvbnm.]+/","_",$str);
	    $str = trim($str,"_");
	    return $str;
	}

	/**
	 * Добавляет закачанный файл в хранилище
	 **/
	public function addUploaded($src,$name) {
	    $name = self::normalizeName($name);
	    if(!$this->exists()) {
	        app()->msg("Вы пытаетесь закачать файл в несуществующий объект",1);
	        return;
	    }
	    $this->prepareFolder();
	    $path = $this->path()."";
	    $dest = $path.$name;
        Core\File::mkdir($path);
	    Core\File::moveUploaded($src,$dest);
	    return Core\File::get($dest)->path();
	}

	/**
	 * Добавляет файл в хранилище
	 **/
	public function add($src,$name) {
	    $name = self::normalizeName($name);
	    if(!$this->exists()) {
			return;
		}
	    $this->prepareFolder();
	    $path = $this->path()."";
	    $dest = $path.$name;

	    if(Core\File::get($src)->path() == "/") {
        	throw new \Exception("reflex_storage::add() first argument cannot be void");
	    }

	    Core\File::get($src)->copy($dest);
	    return Core\File::get($dest)->path();
	}

	public function mkdir($name) {
	    if(!$this->exists()) {
            return;
        }
	    $this->prepareFolder();
	    Core\File::mkdir("{$this->path()}/$name");
	}

	/**
	 * Удаляет файл из хранилища
	 * @todo добавить проверку безопасности
	 **/
	public function delete($name) {

        if(!$name) {
            throw new \Exception("Storage::delete void argument");
        }

	    if(!$this->exists()) {
            return;
        }

	    $path = "{$this->path()}/$name";
	    Core\File::get($path,1)->delete(true);
	}

	/**
	 * Очищает хранилище, удаляет все файлы
	 **/
	public function clear() {
	    if(!$this->exists()) {
	        return;
        }
	    $path = $this->path();
	    Core\File::get($path,1)->delete(true);
	    //$this->reflex()->reflex_afterStorage();
	}

	/**
	 * Добавляет файл из нативной файловой системы (или http) в хранилище
	 **/
	public function addNative($url,$name=null) {

	    if(!$url) {
	        return;
		}

	    if(!$name) {
	        $name = strtolower(file::get($url)->name());
		}

	    // Скачиваем файл во временную папку
	    $dir = file::tmp();
	    $data = file_get_contents($url);

	    if(!$data)
	        return false;

	    $tmpname = $dir."/".$name;
	    file::get($tmpname)->put($data);

	    // Добавляем файл в хранилище
	    $img = $this->add($tmpname,$name);

	    // Убираем временные файлы
	    file::get($tmpname)->delete(true);

	    return $img;
	}

}
