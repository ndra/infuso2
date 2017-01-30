<?

namespace Infuso\MMS\Minify\Service;
use \Infuso\Core;
use MatthiasMullie\Minify;

class CSS extends Core\Service {

    public function defaultService() {
        return "minify/css";
    }
    
    public function minify($src) {
        $minifier = new Minify\CSS($src);
        return $minifier->minify();      
    }

}
