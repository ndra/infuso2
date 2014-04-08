<?

namespace Infuso\Template;

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

function widget() {
	echo "Ололо я виджет!";
}
