<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Log extends Base {
    
    public function post_send($p) {

        service("ar")->create(Model\Log::inspector()->className(), array(
            "taskId" => $p["taskId"],
            "text" => $p["text"],
        ));

    }
        
}
