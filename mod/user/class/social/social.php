<?

/**
 * Модель авторизации в социальной сети
 **/
class user_social extends reflex {

    

public static function recordTable() {return array (
  'name' => 'user_social',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'az7k1zjme6o4erowgbopesqk1ztwub',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'indexEnabled' => '0',
    ),
    1 => 
    array (
      'id' => 'qmlz34ez7fuzjpubtmg23cuhtygrok',
      'name' => 'identity',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => 2,
      'indexEnabled' => 1,
    ),
    2 => 
    array (
      'id' => 'vstfust49bjka2om1itp9bqm9hxfvh',
      'name' => 'userID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => 2,
      'label' => 'Пользователь',
      'indexEnabled' => 1,
      'class' => 'user',
    ),
    3 => 
    array (
      'id' => 'k50qmuzq8503yli7m9s3caixm5hnw9',
      'name' => 'data',
      'type' => 'puhj-w9sn-c10t-85bt-8e67',
      'editable' => 2,
      'label' => 'Данные',
      'indexEnabled' => 1,
    ),
    4 => 
    array (
      'name' => 'network',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => 2,
      'id' => '89bqp1rx8g0d49rx8abqf9bnyes7fu',
      'label' => 'Соц. сеть',
      'indexEnabled' => 0,
    ),
  ),
);}

private static $sessionKey = "user:social";

    /**
     * Возвращает коллекцию всех элементов
     **/
    public static function all() {
        return reflex::get(get_class());
    }

    /**
     * @return Возвращает элемент по id
     **/
    public static function get($id) {
        return reflex::get(get_class(),$id);
    }

    /**
     * Активирует социальный профиль в данной сессии
     **/
    public function addActive($social) {
        mod::session(self::$sessionKey,$social->id());
    }

    /**
     * Возвращает активный социальный профиль
     **/
    public function active() {
        return self::all()->eq("id",mod::session(self::$sessionKey))->one();
    }

    /**
     * @return Возвращает пользователя, к которому привязан данный социальный профиль
     **/
    public function user() {
        return $this->pdata("userID");
    }

    public function reflex_parent() {
        return $this->user();
    }

    /**
     * Прикрепляет данный социальный профиль к активному пользователю
     **/
    public static function appendToActiveUser() {

        $user = user::active();
        if(!$user->exists()) {
            return;
        }

        if(!mod::session(self::$sessionKey)) {
            return;
        }

        self::active()->data("userID",$user->id());
        $_SESSION[self::$sessionKey] = null;

    }

    public function reflex_title() {
        return $this->data("identity");
    }

    /**
     * Возвращает данные, предоставленные социальной сетью ввиде массива
     **/
    public function socialData($key=null) {
        $ret = $this->pdata("data");
        if($key)
            $ret = $ret[$key];
        return $ret;
    }

    /**
     * Возвращает юзерпик пользователя
     **/
    public function userpick() {
        return $this->socialData("photo_big");
    }

    /**
     * Возвращает имя пользователя
     **/
    public function firstName() {
        return $this->socialData("first_name");
    }

    /**
     * Возвращает фамилию
     **/
    public function lastName() {
        return $this->socialData("last_name");
    }

    /**
     * Возвращает название социальной сети, к которой принадлежит данный профиль
     * на русском языке
     **/
    public function networkName() {
        $allNets = array(
            "vkontakte" => "Вконтакте",
            "odnoklassniki" => "Одноклассники",
            "mailru" => "Mail.ru",
            "facebook" => "Facebook",
            "twitter" => "Twitter",
            "google" => "Google",
            "yandex" => "Яндекс",
            "livejournal" => "LiveJournal"
        );
        
        return $allNets[$this->socialData("network")];
    }


    /**
     * Возвращает строку, идентифицирующую социальный профиль
     * Это может быть ник пользователя или ссылка на профиль в соцсети
     * Возвращаемое значение определяется социальной сетью
     **/
    public function identity() {
        return $this->socialData("identity");
    }
    
    /**
     * Возвращает название социальной сети, к которой принадлежит данный профиль
     **/
    public function network() {
        return $this->socialData("network");
    }
    
    public function icon16() {
        return "/user/res/social-icons-16/".$this->network().".png";
    }
    
    public function reflex_beforeStore() {
        $this->data("network", $this->network());
    }

}
