<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Класс для подключения стандартных библиотек
 **/
class Lib {

    public function path() {
        return service("classmap")->getClassBundle(get_class())->path()."/res/";
    }

    public function jq() {
        app()->tm()->singleJS(self::path()."/js/jquery-2.1.0.min.js",-1000);
    }

    /**
     * @todo Сделать чтобы параметром можно было бы передавать название темы
     **/
    public function jqui() {
        self::jq();
        app()->tm()->js("http://yandex.st/jquery-ui/1.10.4/jquery-ui.min.js");
        app()->tm()->css("http://yandex.st/jquery-ui/1.10.4/themes/base/jquery-ui.min.css");
    }
    
    public function reset() {
        app()->tm()->css(self::path()."/css/reset.css",-1000);
    }
    
    public function modjs() {
        self::jq();
        app()->tm()->js(self::path()."/js/mod.js",-900);
        app()->tm()->js(self::path()."/js/mod.jquery.js",-900);
    }
    
    public function modJSUI() {
        self::jq();
        app()->tm()->js(self::path()."/js/mod.window.js");
        app()->tm()->js(self::path()."/js/mod.list.js");
        app()->tm()->js(self::path()."/js/mod.tree.js");
        app()->tm()->js(self::path()."/js/mod.layout.js");
    }

    public function d3() {
        js("http://d3js.org/d3.v3.min.js");
    }
    
    public function sortable() {
        js(self::path()."/js/sortable.min.js");
    }

}
