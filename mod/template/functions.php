<?

namespace Infuso\Template;
use \Infuso\Core;

function exec() {
	$args = func_get_args();
	call_user_func_array(array("tmp","exec"),$args);
}

function region() {
	$args = func_get_args();
	call_user_func_array(array("tmp","region"),$args);
}

function add() {
	$args = func_get_args();
	call_user_func_array(array("tmp","add"),$args);
}

function header() {
	tmp::header();
}

function footer() {
	tmp::footer();
}

function js() {
	$args = func_get_args();
	call_user_func_array(array("tmp","js"),$args);
}

function css() {
	$args = func_get_args();
	call_user_func_array(array("tmp","css"),$args);
}

function action() {
    $args = func_get_args();
	return call_user_func_array(array("\\Infuso\\Core\\Action","get"),$args);
}

function modjs() {
	Lib::modjs();
}

/**
 * @todo Рефакторить скорость
 * @todo Сделать чтобы оно понимало полный путь к классу
 **/
function widget($name) {
	$name = strtolower($name);
	$current = Template::current();
	foreach(Core\Mod::service("classmap")->classes(Widget::inspector()->classname()) as $class) {
	    if($class::inspector()->bundle()->path() == $current->bundle()->path()) {
	        $reflect = new \ReflectionClass($class);
			if (strtolower($reflect->getShortName()) === $name) {
			    return new $class;
            }
	    }
	}
}

function e($str) {
	return \util::str($str)->esc();
}

function esc($str) {
	return e($str);
}

function helper($str) {
	return tmp::helper($str);
}



