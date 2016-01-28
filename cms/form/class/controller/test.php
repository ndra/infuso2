<?

namespace Infuso\CMS\Form\Controller;
use \Infuso\Core;

/**
 * Контроллер-валидатор для форм
 **/
class Test extends Core\Controller {

    public function indexTest() {
        return \Infuso\Core\Superadmin::check();
    }

    public function index($p) {
    
        $captcha = new \Infuso\CMS\Form\Captcha("a57id52yg7s3piawotvv");
        echo "<br/>";
        echo $captcha->img();
        echo "<br/>";
        echo $captcha->privateCode();
        echo "<br/>";
        echo "<img src='{$captcha->img()}' />";
        echo $captcha->checkCode("634kad");
       // echo "<br/>";
       // echo $captcha->publicCode();

    }

}
