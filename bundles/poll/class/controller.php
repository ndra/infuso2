<?

namespace Infuso\Poll;


/**
 * Контроллер опроса
 **/
class Controller extends \Infuso\Core\Controller {

    public static function postTest() {
        return true;
    }

    public static function post_submit($p) {

        $cookie = Model\Poll::getCookie();       
        $poll = Model\Poll::get($p["pollId"]);
        
        if(!$poll->data("active")) {
            throw new \Exception("Non active vote (id='{$p[pollId]}')");
        }
        
        switch($poll->data("mode")) {

            // Разрешен один ответ
            case Model\Poll::MODE_SINGLE:
                $option = end($p["options"]);
                $poll->addAnswer($option);
                break;

            // Разрешено несколько ответов
            case Model\Poll::MODE_MULTY:
                $options = array_unique($p["options"]);
                foreach($options as $option) {
                    $poll->addAnswer($option);
                }
                break;
        }

        return app()->tm("/poll/widget/ajax")
            ->param("poll", $poll)
            ->getContentForAjax();

    }

}
