<?

namespace NDRA\Plugins;
use \Infuso\Core;

class Fancybox extends Core\Component {

    public static function inc() {
        \Infuso\Template\Lib::jq();
        app()->tm()->js(self::inspector()->bundle()->path()."/res/fancybox/jquery.fancybox.pack.js");
        app()->tm()->css(self::inspector()->bundle()->path()."/res/fancybox/jquery.fancybox.css");
    }

}
