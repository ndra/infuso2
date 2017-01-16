<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Контроллер для восстановлания пароля
 **/
class Recovery extends Core\Controller {

    public function controller() {
        return "password-recovery";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/user-actions/recovery")->exec();
    }
    
    public function index_newpassword($p) {
        //app()->tm("/user-actions/recovery-new-password")->exec();
        
        $token = $p["token"];
        $user = service("user")->byToken($token);
        
        if(!$user->checkToken($token, array(
            "type" => "password-recovery" 
        ))) {
            app()
                ->tm("/user-actions/recovery-failed")
                ->exec();
            return;
        }
        
        app()
            ->tm("/user-actions/recovery-new-password")
            ->param("user", $user)
            ->exec();
        
    }
    
    public function postTest() {
        return true;
    }
    
    public function post_send($p) {
    
        $user = \Infuso\User\Model\User::byEmail($p["email"]);
        
        if($user->exists()) {
        
            // Создаем токен
            $token = $user->generateToken(array(
                "type" => "password-recovery",
                "lifetime" => 3600 * 24,
            ));
            
            $url = Core\Action::get(get_class(), "newpassword", array("token" => $token))->url();
           
            service("mail")
                ->create()
                ->to($email)
                ->message("Для восстановления пароля перейдите по ссылке: ".$url)
                ->code("/useractions/recovery")
                ->param("email", $user->email())
                ->param("url", $url)
                ->send();
        }
        
        return app()
            ->tm("/user-actions/recovery/after-ajax")
            ->getContentForAjax();
        
    }

}
