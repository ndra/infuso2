<?

namespace Infuso\Template;
use Infuso\Core;
use Infuso\Core\File;

class Tmp implements Core\Handler {

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
            "noindex" => "noindex",
		);
		$method = $map[$xmethod];
		
		if(!$method) {
		    throw new \Exception("tmp::{$xmethod} not found");
		}
    
        $processor = Core\Mod::app()->tmp();
        
        return call_user_func_array(array(
            $processor,$method
		),$args);
    }

	/**
	 * Статический метод для добавляния в хэдер заголовков метаданных
	 * @Вынести меты в шаблон tmp/header
	 **/
    public function headInsert() {

        $head = "";

        $head.= tmp::conveyor()->exec();

        echo $head;

    }

    public static function nocache() {
        tmp::conveyor()->preventCaching(true);
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

    public static function helper($html) {
        return \Infuso\Template\Helper::fromHTML($html);
    }

    public static function widget($name) {
        return Widget::get($name);
    }

}
