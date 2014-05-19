<?

namespace Infuso\Cms\Log;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Cms\Reflex;


/**
 * Служба записи в системный лог
 **/
class Service extends Core\Service {

    public function defaultService() {
        return "log";
    }   
    
    public function log($params) {
        service("ar")->create(Log::inspector()->className(), $params);
    } 

}
