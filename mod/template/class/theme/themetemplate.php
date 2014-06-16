<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Класс шаблона темы оформления
 * У одного шаблона могут быть несколько файлов в разных темах
 * Используется в редакторе тем
 **/
class ThemeTemplate extends Core\COmponent {

	private $theme = null;
	
	private $relName = null;
	
	public function __construct($theme = null, $relName = null) {
	    $this->theme = $theme;
        
        $relName = trim($relName,"/");
	    $this->relName = $relName;
	}

	/**
	 * Возвращает тему
	 **/
	public function theme() {
	    return $this->theme;
	}

	/**
	 * Возвращает имя шаблона относительно темы
	 **/
	public function relName() {
	    return $this->relName;
	}
    
    /**
     * Возвращает полное имя шаблона
     **/         
    public function fullName() {
        $name = $this->theme()->base()."/".$this->relName();
        $name = preg_replace("/[\:\.\/]+/","/",$name);
        $name = trim($name, "/");
        return $name;
    }
    
    /**
     * Возвращает последнюю часть имени шаблона
     **/          
    public function lastName() {
        return end(explode("/", $this->relName()));
    }
    
    /**
     * Возвращает глубину шаблона относительно темы
     **/          
    public function depth() {     
        if($this->relName()==="") {
            return 0;
        }
        return sizeof(explode("/", $this->relName()));
    }
    
    /**
     * Возвращает дочерние шаблоны данного шаблона
     **/         
    public function children() {   
        $ret = array(); 
        $rel = $this->relName();
        if($rel != "") {
            $rel.= "/";
        }
        foreach($this->theme()->templates() as $template) {
            if(substr($template->relName(),0,strlen($rel)) == $rel) {
                if($template->depth() == $this->depth() + 1) {
                    $ret[] = $template;
                }
            }
        }
        return $ret;
    }
    
    public function parent() {
        $name = explode("/",$this->relName());
        array_pop($name);
        $name = implode("/", $name);
        return new self($this->theme(), $name);
    }
    
    /**
     * Возвращает исходнгый файл шаблона
     **/         
    public function srcFile($ext) {
        $name = Core\File::get($this->theme()->path())."/".$this->relName().".".$ext;
        return Core\File::get($name);
    }
    
    /**
     * Возвращает содержимое шаблона требуемого типа
     **/        
    public function contents($ext) {
        $file = $this->srcFile($ext);
        return $file->data();
    }
    
    /**
     * Записывает содержимое шаблона
     **/         
    public function setContents($ext,$data) {
        $file = $this->srcFile($ext);
        return $file->put($data);
    }
    
    /**
     * ДОбавляет дочерний шаблон в данный шаблон
	 **/
    public function add($name) {     
        $dest = Core\File::get($this->srcFile("php")->up()."/".$this->srcFile("php")->basename()."/".$name.".php");
        Core\File::mkdir($dest->up());
        $dest->put("<?\n\n");        
    }
    
    /**
     * Переименовывает шаблон
     **/
    public function rename($newName) {
        $newLastName = end(explode("/", $newName));
        $newFolder = Core\File::get($this->theme()->path()."/".$newName)->up();
        Core\File::mkdir($newFolder);
        $this->srcFile("php")->rename($newFolder."/".$newLastName.".php");
        $this->srcFile("js")->rename($newFolder."/".$newLastName.".js");
        $this->srcFile("css")->rename($newFolder."/".$newLastName.".css");
        
        // Переименовываем
        $folder = Core\File::get($this->theme()->path()."/".$this->relName());
        $folder->rename($newFolder."/".$newLastName);
    }
    
    /**
     * Удаляет текущий шаблон
     **/         
    public function delete() {
        $this->srcFile("php")->delete();
        $this->srcFile("js")->delete();
        $this->srcFile("css")->delete();        
        $subfolder = Core\File::get($this->srcFile("php")->up()."/".$this->srcFile("php")->basename());
        $subfolder->delete(true);
    }
    
}
