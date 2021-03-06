<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

/**
 * Модель токена пользователя
 **/
class Token extends ActiveRecord\Record {

    private $token;
    
    const ID_LENGTH = 20;

	public static function model() {
	
		return array (
			'name' => get_class(),
			'fields' =>
			array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'editable' => '0',
				), array (
					'name' => 'userId',
					'type' => 'link',
					'editable' => '2',
					'label' => 'Пользователь',
					'class' => User::inspector()->className(),
				), array (
					'name' => 'lifetime',
					'type' => 'bigint',
                    "label" => "Время жизни",
					'editable' => '2',
				), array (
					'name' => 'start',
					'type' => 'datetime',
                    "label" => "Дата отсчета времени жизни",
					'editable' => '2',
                    "default" => "now()",
				), array (
					'name' => 'expires',
					'type' => 'datetime',
                    "label" => "Истекает",
					'editable' => '2',
				), array (
					'name' => 'type',
					'type' => 'textfield',
					'editable' => '2',
					'label' => 'тип',
				), array (
					'name' => 'token',
					'type' => 'string',
					'editable' => '2',
					'label' => 'Токен',
				),
			),
		);
	
	}

    /**
	 * Возвращает все авторизации всех пользователей
 	**/
	public static function all() {
		return service("ar")->collection(get_class());
	}

	public static function get($id) {
		return service("ar")->get(get_class(), $id);
	}
    
    /**
     * Возвращает токен по публичному токену
     **/
	public static function byToken($originalToken) {
        $idLength = self::ID_LENGTH;
        $left = substr($originalToken, 0, $idLength);
        $left = service("db")->quote($left);
        $tokenObj = self::all()->where("left(`token`, {$idLength}) = {$left}")->one();
        
        // Истекшие токены не считаются
        if($tokenObj->expired()) {
            return new self();
        }
        
        // На всякий случай проверяем токен
        if(!$tokenObj->checkToken($originalToken)) {
            return new self();
        }
        
        return $tokenObj;
	}

    /**
     * Возвращает пользователя к которому привязан токен
     **/
	public function user() {
		return User::get($this->data("userId"));
	}
    
    public function recordParent() {
        return $this->user();
    }
    
    public function beforeCreate() {
        $id = \Infuso\Util\Util::id(20);
        $token = \Infuso\Util\Util::id(40); 
        $private = $id.$token;
        $crypted = $id.Core\Crypt::hash($token);
        $this->token = $private;
        $this->data("token", $crypted);
    }
    
    public function beforeStore() {
        $this->data("expires", $this->pdata("start")->shift($this->data("lifetime")));
    }
    
    /**
     * Возвращает публичный токен
     * Работает только после создания токена (в том же вызове скрипта)
     * При извлечении токена из базы, вернет null
     **/
    public function token() {
        return $this->token;
    }
    
    /**
     * Возвращает флаг того что токен устарел
     **/
    public function expired() {
        return $this->pdata("expires")->stamp() < \Infuso\Core\Date::now()->stamp();
    }
    
    /**
     * Продлевает токен, устанавливая в качестве даты начала текущую
     * Запускается не чаще чем раз в час чтобы не насиловать базу
     **/
    public function extend() {    
        if(\Infuso\Core\Date::now()->stamp() - $this->pdata("start")->stamp() < 3600) {
            return;
        }
        $this->data("start", \Infuso\Core\Date::now());
    }
    
    public function checkToken($token) {
        if(!$token) {
            return false;
        }
        $public = substr($token, self::ID_LENGTH);
        $private = substr($this->data("token"), self::ID_LENGTH);
        return Core\Crypt::checkHash($private, $public);
    }

}
