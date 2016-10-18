<?

namespace Infuso\SocialAuth\Provider;
use \Infuso\Core;

/**
 * Базовый класс для провайдера входа через соцсети
 **/
class Google extends Provider {

    public function indexTest() {
        return true;
    }

    public static function name() {
        return "google";
    }
    
    public function authredirect() {
        $action = new Core\Action(get_class(), "redirect");
        app()->redirect($action->url());
    }
    
    /**
     * Контроллер, который перенаправляет пользователя на сайт гугла для авторизации
     **/
    public function index_redirect() {
    
        $redirect = (new Core\Url(new Core\Action(get_class(), "result")))
            ->scheme("http")
            ->domain("infuso2.mysite.ru");
            
        echo $redirect;
    
        $url = 'https://accounts.google.com/o/oauth2/auth';
        $params = array(
            'redirect_uri' => (String) $redirect,
            'response_type' => 'code',
            'client_id' => $this->param("client_id"),
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        );
        
        echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';

    }
    
    public function index_result() {
    }

}
