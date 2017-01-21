<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Контроллер для управления заказом
 **/
class Register extends Core\Controller {

    public function controller() {
        return "register";
    }

    public function indexTest() {
        return true;
    }
    
    public function postTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/user-actions/register")->exec();
    }
    
    public function index_verify() {
    }
    
    /**
     * @todo убрать rand()!
     **/
    public function post_register($p) {
    
        // @todo убрать это! 
        $p["data"]["email"] .= rand();
    
        $user = service("user")->create($p["data"]);
        $token = $user->generateToken(array(
            "type" => "email-verification",
            "lifetime" => 3600 * 24
        ));
        
        // Ссылка на активацию
        $url = Core\Action::get(get_class(), "verify", array("token" => $token))->url();
        $url = new Core\Url($url);
        $url = $url->absolute();
        
        service("mail")
            ->create()
            ->to($user->email())
            ->subject("Подтверждение электронной почты")
            ->message("Для подтверждения электронной почты перейдите по ссылке ".$url)
            ->code("useractions/email-verification")
            ->param("url", $url)
            ->user($user->id())
            ->send();
            
        return app()->tm("/user-actions/register/after")
            ->param("user", $user)
            ->getContentForAjax();
            
    }

}
