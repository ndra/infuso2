<?

namespace Infuso\Site\Controller;
use Infuso\Core;

/**
 * Контроллер для управления промокодами
 **/
class TimepadPromocodeManage extends Core\Controller {

	public function postTest() {
	    return true;
	}
    
    public function post_disablePromocodes($p) {    
        $dummy = new \Infuso\Site\Model\EVent();
        $api = new \Infuso\Site\TimepadApi($dummy->param("timepad/key"));
        $orgId = $dummy->param("timepad/id");   
        $result = $api->request(
            "https://api.timepad.ru/v1/organizations/{$orgId}/custom_method/removePromocodePolicies",
            ["args" => ["event_id" => $p["eventId"]]]
        );
        app()->msg("Выполнено");
    }
    
    public function post_disableAll($p) {    
        $dummy = new \Infuso\Site\Model\EVent();
        $api = new \Infuso\Site\TimepadApi($dummy->param("timepad/key"));
        $orgId = $dummy->param("timepad/id");   
        $result = $api->request(
            "https://api.timepad.ru/v1/organizations/{$orgId}/custom_method/removeAllPolicies",
            ["args" => ["event_id" => $p["eventId"]]]
        );
        app()->msg("Выполнено");
    }
    
    public function post_enable($p) {    
        $dummy = new \Infuso\Site\Model\EVent();
        $api = new \Infuso\Site\TimepadApi($dummy->param("timepad/key"));
        $orgId = $dummy->param("timepad/id");   
        $result = $api->request(
            "https://api.timepad.ru/v1/organizations/{$orgId}/custom_method/restoreOrgPolicies",
            ["args" => ["event_id" => $p["eventId"]]]
        );
        app()->msg("Выполнено");
    }
    
    
}
