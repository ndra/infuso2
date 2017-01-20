<?

namespace Infuso\User;
use \Infuso\Core;

class Service extends Core\Service {

    private static $activeUser = null;
 
    public function defaultService() {
        return "user";
    }
    
    public function initialParams() {
        return array(
            "deleteUnverfiedUserDays" => 7,
        );
    }

	public static function confDescription() {
	    return array(
	        "components" => array(
	            strtolower(get_class()) => array(
	                "params" => array(
	                    "deleteUnverfiedUserDays" => "Через сколько дней удалять пользователей, не подтвердивших почту",
					),
				),
			),
		);
	}
    
    /**
     * Возвращает список юзверов
     **/
    public function users() {
        return Model\User::all();  
    }
    
    public function all() {
        return Model\User::all(); 
    }   
    
    public function get($id) {
        return service("ar")->get(Model\User::inspector()->className(), $id);
    }
    
    public function byToken($token) {
        return \Infuso\User\Model\Token::byToken($token)->user();
    }
    
    /**
     * Возвращает список юзверов c неподвержедной почтой
     **/
    public function unverfiedUsers() {
        return $this->users()->eq("verified", 0);  
    }
    
    /**
    * Удяляет всех не активированых пользователей у который рега > deleteUnverfiedUserDays   
    **/
    public function deleteUnverfiedUsers() {
        $deleteTime = \Infuso\Core\Date::now()->shiftDay(-$this->param("deleteUnverfiedUserDays"));
        $users = $this->unverfiedUsers()->lt("registrationTime", $deleteTime);
        $users->delete();
    }
    
    /**
     * Проверяет пароль на соответствие требованиям безопасности (минимальная длина и т.п.)
     * Проверкой пароля конкретного пользователя этот метод не занимается
     * @todo вынести в настройки минимальную длину пароля
     **/
    public static final function _checkAbstractPassword($password) {
    
        // Обрезаем пробелы на всякий случай
        $password = trim($password);
        
        // Проверяем минимальную длину
        $passlen = 5;
        if(strlen($password) < $passlen) {
            app()->msg("Слишком короткий пароль. Минимальное количество символов: $passlen",1);
            return false;
        }
        
        return $password;
    }
    
    /**
     * Возвращает пользователя по адресу электронной почты
     **/
    public static final function byEmail($email) {

        // Если вдруг у пользователя не будет почты, мы не должны под ним логиниться
        // На всякий случай делаю проверку
        if(!trim($email)) {
            return user::get(0);
        }

        return self::all()->eq("email",$email)->one();
    }
    
    /**
     * Создает и возвращает нового пользователя на основе массива данных
     * $p["password"] - пароль, который потом зашифруеттся. В явном виде пароль в базе не хранится
     * $p["email"] - электронная почта пользователя
     * @todo там какой-то бред с определением полей, которые можно указать при создании
     **/
    public static function create($p) {

         // Удаляем пробельные символы вокруг логина и пароля
        if(!$p["password"] = self::checkAbstractPassword($p["password"])) {
            throw new Core\Exception\UserLevel("Неподходящий пароль");
        }

        // Проверяем электронную почту
        if(!$p["email"] = self::normalizeEmail($p["email"])) {
            throw new Core\Exception\UserLevel("Ошибка в адресе электронной почты");
        }

        // Ищем пользователя с такой электронной почтой
        if(user::byEmail($p["email"])->exists()) {
            throw new Core\Exception\UserLevel("Пользователь с такой электронной почтой уже существует");
        }

        $password = $p["password"];
        $p["password"] = \Infuso\Core\Crypt::hash($p["password"]);

        foreach(user::virtual()->fields() as $field) {
            if($field->editable()) {
                $insert[$field->name()] = $p[$field->name()];
            }
        }
                
        $insert["password"] = $p["password"];
        $insert["email"] = $p["email"];
        $insert["registrationTime"] = \Infuso\Util\Date::now()."";

        $user = service("ar")->create(get_class(), $insert);
        
        $user->password = $password;

        return $user;
    }
    
    /**
     * Возвращает активного (залогиневшегося) пользователя
     * Если пользователь не залогинен, возвращается несуществующий объект
     **/
    public static final function active() {
    
        \Infuso\Core\Profiler::beginOperation("user", "active", null);

        if(!self::$activeUser) {

            $cookie = app()->cookie("login");
            
            $user = null;

            if(strlen($cookie) > 5) {
                $token = \Infuso\User\Model\Token::byToken($cookie);
                if($token->user()->checkToken($cookie, array(
                    "type" => "login"
                ))) {
                    $user = $token->user();
                    $token->extend();
                }
            }

            if($user && !$user->verified()) {
                $user = null;
            }

            if($user && !$user->exists()) {
                $user = null;
            }
            
            if(!$user) {
                $user = new Model\User;
            } 
            
            self::$activeUser = $user;
            $user->thisIsActiveUser = true;
        }
        
        \Infuso\Core\Profiler::endOperation();

        return self::$activeUser;

    }
    
    /**
     * Приводит адрес электронной почты к какноническому виду.
     * Возвращает null, если прверка по режексу не удалась
     **/
    public static final function normalizeEmail($email) {
        $email = strtolower(trim($email));
        $s = "1234567890qwertyuiopasdfghjklzxcvbnm\.\-\_";
        $r = preg_match("/^[$s]+@[$s]+$/",$email,$m);
        return $r ? $email : false;
    }
    
}
