<?

namespace Infuso\Template;
use \Infuso\Core;

function exec() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"exec"),$args);
}

function tmp() {
	$args = func_get_args();
	return call_user_func_array(array (app(), "tm"), $args);
}

function region() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"region"),$args);
}

function add() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"add"),$args);
}

function header() {
	app()->tm()->header();
}

function footer() {
	app()->tm()->footer();
}

function js() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"js"),$args);
}

function singleJS() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"singleJS"),$args);
}

function css() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"css"),$args);
}

function singleCSS() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"singlecss"),$args);
}

function param() {
	$args = func_get_args();
	return call_user_func_array(array(app()->tm(),"param"),$args);
}

function head() {
	$args = func_get_args();
	call_user_func_array(array(app()->tm(),"head"),$args);
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
    return Widget::get($name);
}

function e($str) {
	return \util::str($str)->esc();
}

function esc($str) {
	return e($str);
}

function helper($str) {
	return Helper::fromHTML($str);
}

function title($title) {
	app()->tm()->param("head/title", $title);
}



