<?

namespace NDRA\Plugins;


class Slideshow extends \Infuso\Core\Component {

	/**
	 * Подключает слайдшоу
	 **/
	public static function inc() {
		app()->tm()->jq();
		\Infuso\Template\Lib::modJS();
		app()->tm()->js(self::inspector()->bundle()->path()."/res/slideshow/slideshow.js");
		app()->tm()->css(self::inspector()->bundle()->path()."/res/slideshow/slideshow.css");
	}

	/**
	 * Конструктор
	 **/
	public static function create($loader = null) {
		return new self($loader);
	}

	/**
	 * Конструктор
	 **/
	public function __construct($loader = null) {
		$this->param("loader", $loader);
        $this->param("loaderImg", self::inspector()->bundle()->path()."/res/slideshow/loading.gif");
	}

	/**
	 * Перемотать на фотографию с номером $n
	 **/
	public function select($n) {
		$this->param("select",$n);
		return $this;
	}
	
	/**
	 * Привязывает к jQuery-селектору событие click, которое открывает эту галерею
	 **/
	public function bind($selector) {   
		self::inc();                
		$params = json_encode($this->params());
		$js = "";
		$js.= "$(function(){";
		$js.= "ndra.slideshow.bind('$selector',$params);";
		$js.= "})";
		app()->tm()->script($js);
	}

}