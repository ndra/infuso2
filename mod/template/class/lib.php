<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Класс для подключения стандартных библиотек
 **/
class Lib {

	public function path() {
	    return \mod::service("classmap")->getClassBundle(get_class())->path()."/res/";
	}

    public function jq() {
        tmp::singleJS(self::path()."/js/jquery-2.1.0.min.js",-1000);
    }

    /**
     * @todo Сделать чтобы параметром можно было бы передавать название темы
     **/
    public function jqui() {
        self::jq();
        tmp::js("http://yandex.st/jquery-ui/1.10.3/jquery-ui.min.js");
        tmp::css("http://yandex.st/jquery-ui/1.10.3/themes/base/jquery-ui.min.css");
    }
    
    public function reset() {
        tmp::css(self::path()."/css/reset.css",-1000);
    }
    
    public function modjs() {
        self::jq();
        tmp::js(self::path()."/js/mod.js",-900);
        tmp::js(self::path()."/js/mod.jquery.js",-900);
    }

}
