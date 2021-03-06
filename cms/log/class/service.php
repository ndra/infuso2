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
        $params["user"] = app()->user()->id();
        service("ar")->create(Log::inspector()->className(), $params);
    }   
    
    public function all() {
        return service("ar")
            ->collection(Log::inspector()->className())
            ->desc("datetime");
    }

}
