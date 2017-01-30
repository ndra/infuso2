<?

namespace Infuso\MMS\Minify\Service;
use \Infuso\Core;
use MatthiasMullie\Minify;

class JS extends Core\Service {

    public function defaultService() {
        return "minify/js";
    }
    
    public function minify($src) {
        $minifier = new Minify\JS($src);
        return $minifier->minify(); 
    }

}
