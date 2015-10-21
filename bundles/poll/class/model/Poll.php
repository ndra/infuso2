<?

namespace Infuso\Poll\Model;

/**
 * Модель опроса
 **/
class Poll extends \Infuso\ActiveRecord\Record {

    public static function model() {

        return array (
            'name' => self::inspector()->className(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh', 
                ), array (
                    'name' => 'created',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => '2',
                    "default" => "now()",
                    'label' => 'Дата создания',
                ), array (
                    'name' => 'title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Вопрос',
                ), array (
                    'name' => 'active',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'editable' => '1',
                    'label' => 'Голосование активно',
                ), array (
                    'name' => 'mode',
                    'type' => 'fahq-we67-klh3-456t-plbo',
                    'editable' => '1',
                    'label' => 'Режим',
                    'indexEnabled' => '1',
                    'list' => array (
                        "Один ответ",
                        "Несколько ответов",
                    ),
                ), 
            ),
        );
    
    }

    /**
     * @return Возвращает коллекцию всех опросов
     **/
    public static function all() {
        return service("ar")->collection(get_called_class())
            ->desc("active")
            ->desc("created", true)
            ->param("icon", "hand");
    }

    /**
     * @return Возвращает опрос по id
     **/
    public static function get($id) {
        return service("ar")->get(get_called_class(),$id);
    }

    /**
     * @return Возвращает последний активный опрос
     **/
    public static function last() {
        return self::all()->eq("active",1)->one();
    }

    /**
     * @return Возвращает коллекцию вариантова ответа на вопрос
     **/
    public function options() {
        return Option::all()
            ->eq("pollId",$this->id());
    }  

    /**
     * @return Коллекция ответов на данный вопрос
     **/
    public function answers() {
        return Answer::all()->eq("pollId",$this->id());
    }
    
    public function resultData() {
        $ret = array();
        return $ret;
    }

    /**
     * Добавляет ответ в вопрос
     * @param $optionID - id варианта ответа
     * @param $cookie - cookie-ключ для защиты от повторного голосования
     **/
    public function addAnswer($optionID,$cookie) {

        if(!$this->data("active")) {
            mod::msg("Голосование закрыто",1);
            return;
        }

        $option = $this->allOptions()->eq("id",$optionID)->one();
        if(!$option->exists()) {
            mod::msg("Недопустимый вариант ответа",1);
            return;
        }

        $this->answers()->create(array(
            "optionId" => $option->id(),
            "cookie" => $cookie
        ));

    }
  
    /**
     * Возвращает cookie-ключ, уникальный для каждого пользователя
     **/
    public function getCookie() {
        $key = "5g03f90jfv03f5btmvz";
        $cookie = app()->cookie($key);
        if(!$cookie) {
            $cookie = \Infuso\Util\Util::id(20);
            app()->cookie($key,$cookie);
        }
        return $cookie;
    }

    /**
     * true, если пользователь проголосовал за последние 24 часа
     **/
    public function voted() {
        return !!$this->answers()->eq("cookie",self::getCookie())->count();
    }

}
