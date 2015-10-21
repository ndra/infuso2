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
                    "default" => "now",
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
    public static function allEvenHidden() {
        return service("ar")->collection(get_called_class())
            ->desc("active")
            ->desc("created", true)
            ->param("icon", "hand");
    }

    /**
     * @return Возвращает коллекцию всех опросов
     **/
    public static function all() {
        return self::allEvenHidden()
            ->eq("active",1);
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
            "optionID" => $option->id(),
            "cookie" => $cookie
        ));

    }

    /**
     * Добавляет вариант ответа ввиде текста
     **/
    public function addText($text,$cookie) {

        // Нормализуем текст
        // Это даст нам больше шансов что одинаковые ответы объединятся
        $text = util::str($text)->trim()->text()."";

        if(!$text) {
            mod::msg("Недопустимый вариант ответа");
            return;
        }

        $option = $this->allOptions()->eq("lower(title)",$text)->one();
        if(!$option->exists())
            $option = $this->options()->create(array(
                "title" => $text
            ));

        $this->addAnswer($option->id(),$cookie);
    }
    
    
    public function addDraftOption($text,$cookie) {
        // Нормализуем текст
        // Это даст нам больше шансов что одинаковые ответы объединятся
        $text = util::str($text)->trim()->text()."";
    
        if(!$this->data("active")) {
            mod::msg("Голосование закрыто",1);
            return;
        }
        
        if(!$text) {
            return;
        }
        
        $option = $this->options()->eq("lower(title)",$text)->one();
        
        if(!$option->exists()){
            $option = $this->options()->create(array(
                "title" => $text,
                "draft" => 1
            ));
            $option->store();
        }    

        $this->addAnswer($option->id(),$cookie);
            
    }
    
    /**
     * Возвращает cookie-ключ, уникальный для каждого пользователя
     **/
    public function getCookie() {
        $key = "5g03f90jfv03f5btmvz";
        $cookie = mod::cookie($key);
        if(!$cookie) {
            $cookie = util::id(20);
            mod::cookie($key,$cookie);
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
