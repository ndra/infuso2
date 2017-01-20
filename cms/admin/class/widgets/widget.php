<?

namespace Infuso\Cms\Admin\Widgets;
use Infuso\Core;

/**
 * Базовый класс для виджетов, которые выводятся в верхнее меню админки
 **/
abstract class Widget extends Core\Component {

	/**
	 * Выполняет виджет
	 **/
	abstract public function exec();

	/**
	 * @return Выводить ли виджет в меню
	 **/
	public function inMenu() {
		return true;
	}

	/**
	 * @return Выводить ли виджет на главной странице
	 **/
	public function inStartPage() {
		return false;
	}

	/**
	 * @return Возвращает ширину виджета в пикселях
	 **/
	public function width() {
		return 200;
	}

	/**
	 * @return Можно ли выводить этот виджет
	 **/
	public function test() {
	    return app()->user()->checkAccess("admin:showInterface");
	}

	/**
	 * Возвращает массив всех админских виджетов
	 **/
	public function all() {
		$ret = array();
		foreach(service("classmap")->getClassesExtends(get_class()) as $class) {
		    $widget = new $class;
		    if($widget->test()) {
		        $ret[] = $widget;
		    }
		}
		return $ret;
	}

}
