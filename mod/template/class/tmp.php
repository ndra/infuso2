<?

namespace Infuso\Template;
use Infuso\Core;
use Infuso\Core\File;

class Tmp implements Core\Handler {

    private static $templateMap = array();
    private static $obj = null;

    /**
     * Руотер статических методов (старый стиль) в динамические методы (новый стиль)
     * Например tmp::exec() => mod::app()->tmp()->exec();
     **/
    public static function __callStatic($xmethod,$args) {
    
        $xmethod = strtolower($xmethod);
    
        $map = array(
            "get" => "template",
            "exec" => "exec",
            "conveyor" => "conveyor",
            "add" => "add",
            "css" => "css",
            "js" => "js",
            "singlejs" => "singlejs",
            "singlecss" => "singlecss",
            "param" => "param",
            "head" => "head",
            "script" => "script",
            "header" => "header",
            "footer" => "footer",
            "jq" => "jq",
		);
		$method = $map[$xmethod];
		
		if(!$method) {
		    throw new Exception("tmp::{$xmethod} not found");
		}
    
        $processor = Core\Mod::app()->tmp();
        
        return call_user_func_array(array(
            $processor,$method
		),$args);
    }

    public function headInsert() {

        $head = "";

        $obj = tmp::obj();

        // Добавляем <title>
        $title = $obj->meta("title");
        $title = strtr($title,array("<"=>"&lt;",">"=>"&gt;"));
        $head.= "<title>$title</title>\n";

        // Добавляем noindex
        if($obj->meta("noindex") || tmp::param("meta:noindex")) {
            $head.= "<meta name='ROBOTS' content='NOINDEX,NOFOLLOW' >\n";
        }

        // Добавляем меты
        foreach(array("keywords","description") as $name) {
            if($val = trim($obj->meta($name))) {
                $head.= "<meta name='{$name}' content='{$val}' />\n";
            }
        }

        $head.= tmp::conveyor()->exec();

        echo $head;

    }

    /**
     * Запрещает текущую страницу к индексации
     * (На практике устанавливает специальный параметр, который учитывается при построеннии шапки)
     **/
    public static function noindex() {
        tmp::param("meta:noindex",true);
    }

    public static function nocache() {
        tmp::conveyor()->preventCaching(true);
    }

    /**
     * Возвращает / устанавливает "текущий" объект reflex
     **/
    public function obj($obj=null) {
    
        if(self::$obj) {
            return self::$obj;
        }
    
        $action = Core\Mod::app()->action();
        if(!$action) {
            return \reflex::get("reflex_none",0);
        }
    
		list($class,$id) = explode("/",$action->ar());
		return \reflex::get($class,$id);
    }
    
    public function setCurrentObject($obj) {
        self::$obj = $obj;
    }

    /**
     * Возвращает заголовок H1 текущей страницы
     **/
    public static function h1() {
        $ret = tmp::obj()->meta("pageTitle");
        if(!$ret) {
            $ret = tmp::obj()->title();
        }
        return $ret;
    }

    /**
     * Добавляет в регион вызов метода
     **/
    public static function fn($region,$class,$method) {
        $tmp = tmp::get("tmp:fn");
        $tmp->param("class",$class);
        $tmp->param("method",$method);
        $args = func_get_args();
        array_shift($args);
        array_shift($args);
        array_shift($args);
        $tmp->param("args",$args);
        tmp_block::get($region)->add($tmp);
    }

    /**
     * Выводит содержимое региона добавленное при помощи метода add
     **/
    public static function region($block,$prefix="",$suffix="") {
        Block::get($block)->exec($prefix,$suffix);
    }

    /**
     * @return Возвращает объект блока
     **/
    public function block($name) {
        return Block::get($name);
    }

    public static function reset() {
        Lib::reset();
    }

    public function templateMap() {
        return self::$templateMap;
    }

    /**
     * Подключает тему
     * @param $class php-класс или объект темы
     * Если такая тема уже была подключена, то она «всплывет» на самый верх списка
     **/
    public function theme($id) {
        Theme::loadDefaults();
        $theme = Theme::get($id);
        foreach($theme->templatesArray() as $key=>$tmp) {
            self::$templateMap[$key] = $tmp;
		}
    }

	/**
	 * Возвращает путь к файлу шаблона с заданным расширением
	 **/
    public function filePath($template,$ext) {

        Theme::loadDefaults();

        $template = trim($template,"/");
        $ret = self::$templateMap[$template][$ext];

        if($ret) {
            return file::get($ret);
        } else {
            return file::nonExistent();
		}
    }

    public static function helper($html) {
        return \Infuso\Template\Helper::fromHTML($html);
    }

    public static function widget($name) {
        return tmp_widget::get($name);
    }

}
