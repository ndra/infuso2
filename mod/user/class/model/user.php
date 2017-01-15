<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

/**
 * Модель пользователя
 **/
class User extends ActiveRecord\Record {

    private static $activeUser = null;

    private $thisIsActiveUser = false;

    private $errorText = "";
    
    public static function model() {
    
        return array(
            'name' => 'user_list',
            'fields' => array(
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                    'group' => 'Основное',
                ), array(
                    'name' => 'password',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'label' => 'Хэш пароля',
                    'group' => 'Основное',
                ), array (
                    'name' => 'email',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'label' => 'Электронная почта',
                    'group' => 'Основное',
                    "editable" => 2,
                ), array(
                    'name' => 'registrationTime',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => 2,
                    'label' => 'Время регистрации',
                    'group' => 'Основное',
                    "default" => "now()",
                ), array(
                    'name' => 'lastActivity',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => 2,
                    'id' => 'tyvbxplhnw9htkg2qme038gsxwgsxp',
                    'indexEnabled' => 1,
                    'label' => 'Когда был на сайте',
                    'group' => 'Основное',
                ), array(
                    'name' => 'verificationCode',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '2',
                    'label' => 'Код подтверждения операции',
                    'group' => 'Основное',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'verified',
                    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
                    'editable' => 1,
                    'label' => 'Почта подтверждена',
                    'group' => 'Основное',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'extra',
                    'type' => 'puhj-w9sn-c10t-85bt-8e67',
                    'editable' => '1',
                    'label' => 'Дополнительно',
                    'group' => 'Основное',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'firstName',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Имя',
                    'group' => 'Личные данные',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'lastName',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Фамилия',
                    'group' => 'Личные данные',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'nickName',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Никнейм',
                    'group' => 'Личные данные',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'userpic',
                    'type' => 'knh9-0kgy-csg9-1nv8-7go9',
                    'editable' => '1',
                    'label' => 'Юзерпик',
                    'group' => 'Личные данные',
                    'indexEnabled' => '1',
                ), array(
                    'name' => 'country',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'id' => 'p9ztkg03wvh7pvioyaix4uztwgsqyl',
                    'label' => 'Страна',
                    'indexEnabled' => '0',
                    'group' => 'Личные данные',
                ), array(
                    'name' => 'region',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'id' => 'rnwahtf5st81rdkvhnyl63y5r3c5ht',
                    'label' => 'Регион',
                    'indexEnabled' => '0',
                    'group' => 'Личные данные',
                ), array(
                    'name' => 'city',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'id' => '4asx8ub7c9hx4art81b3mvr7plhnce',
                    'label' => 'Город',
                    'indexEnabled' => '0',
                    'group' => 'Личные данные',
                ) ,
            ) ,
        );

    
    }
    
    /**
     * Возвращает коллекцию всех пользователей
     **/
    public static function all() {
        return service("ar")->collection(get_class())
            ->addBehaviour("\\Infuso\\User\\Model\\UserCollection")
			->desc("registrationTime");
    }

    /**
     * @return Возвращает пользователя по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
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
     * Создает виртуального пользователя (без занесения в базу)
     **/
    public final function virtual($data = null) {
        return service("ar")->virtual(get_class(), $data);
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
            return user::get(0);
        }

        // Проверяем электронную почту
        if(!$p["email"] = self::normalizeEmail($p["email"])) {
            app()->msg("Ошибка в адресе электронной почты",1);
            return user::get(0);
        }

        // Ищем пользователя с такой электронной почтой
        if(user::byEmail($p["email"])->exists()) {
            app()->msg("Пользователь с такой электронной почтой уже существует",1);
            return user::get(0);
        }

        self::$password = $p["password"];
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

        return $user;
    }

    private static $password = null;

    /**
     * Возвращает пароль у вновь созданого пользователя.
     * Данная функция будет работать в пределах того скрипта в котором был создан пользователь.
     **/
    public final function password() {
        return self::$password;
    }

    /**
     * Проверяет код, сгенерированный методом newCode
     **/
    public function testCode($code) {
        list($stamp,$tail) = explode(":", $code);
        $stamp = intval($stamp);

        if(strlen($tail) != 20)
            return false;

        // Сколько часов назад был создан код
        $d = (util::now()->stamp() - $stamp) / 3600;
        
        if($d<0) {
            return false;
        }
        
        if($d>1) {
            return false;
        }

        return $this->data("verificationCode") == $code;
    }

    /**
     * генерирует код
     **/
    public function newCode() {
        $code = util::now()->stamp().":".util::id(20);
        $this->data("verificationCode", $code);
        return $code;
    }

    /**
     * Подтверждает почту пользователя без дополнительных проверок
     **/
    public final function setVerification() {
        if(!$this->data("email")) {
            return $this;
        }
        $this->data("verified", 1);
        return $this;
    }

    /**
     * Снимает подтверждение почты пользователя
     **/
    public final function removeVerification() {
        $this->data("verified", 0);
        return $this;
    }

    /**
     * @return Возвращает флаг подтверждения пользователя (true/false)
     **/
    public final function verified() {
        return !!$this->data("verified");
    }

    /**
     * @return Меняет пароль рользоватея
     **/
    public final function changePassword($pass) {
    
		if(!$this->exists()) {
		    throw new \Exception("Попытка смены пароля у несуществующего пользователя");
		}
    
        $pass = self::checkAbstractPassword($pass);
        if(!$pass) {
            return false;
        }
        $this->data("password", Core\Crypt::hash($pass));
        $cookie = $_COOKIE["login"];
        $this->authorizations()->neq("cookie",$cookie)->delete();
        return true;
    }

    /**
     * Меняет электронную почту пользователя
     **/
    public final function changeEmail($email) {

        if(!$email = self::normalizeEmail($email)) {
            throw new \Exception("Ошибка в адресе электронной почты",1);
            return false;
        }

        if($email == $this->data("email")) {
            return true;
        }

        if(user::byEmail($email)->exists()) {
            throw new \Exception("Пользователь с такой электронной почтой уже существует",1);
            return false;
        }

        $this->data("email", $email);
        return true;
    }

    /**
     * Возвращает активного (залогиневшегося) пользователя
     * Если пользователь не залогинен, возвращается несуществующий объект
     **/
    public static final function active() {
    
        \Infuso\Core\Profiler::beginOperation("user", "active", null);

        if(!self::$activeUser) {

            $cookie = $_COOKIE["login"];

            if(strlen($cookie) > 5) {
                $auth = Auth::all()->eq("cookie", $cookie)->one();
            } else {
                $auth = Auth::get(0);
            }

            $user = $auth->user();

            if(!$user->verified()) {
                $user = user::virtual();
            }

            if(!$user->exists()) {
                $user = user::virtual();
            }
            
            self::$activeUser = $user;
            $user->thisIsActiveUser = true;
        }
        
        \Infuso\Core\Profiler::endOperation();

        return self::$activeUser;

    }

    /**
     * Является ли этот пользователь активным (тем, что залогинен)
     **/
    public function isActiveUser() {

        if($this->exists() && $this->id()==user::active()->id()) {
            return true;
        }

        if($this->thisIsActiveUser) {
            return true;
        }

        return false;

    }

    /**
     * Генерирует пользователю новый код для куков, устанавливает его и возвращает его же
     **/
    private final function newCookie() {
        $cookie = \util::id();
        $auth = service("ar")->create(Auth::inspector()->className(),array(
            "cookie" => $cookie,
            "userID" => $this->id(),
        ));
        return $cookie;
    }

    /**
     * Активирует пользователя без каких-либо проверок
     **/
    public final function activate($keep = null) {
        if(!$this->exists()) {
            return;
        }
        $keepDays = $keep ? 14 : null;
        $cookie = $this->newCookie();
        $expire = $keepDays ? time() + 60 * 60 * 24 * $keepDays : null;
        setcookie("login", $cookie, $expire, "/");
        $_COOKIE["login"] = $cookie;
        self::$activeUser = $this;
        //$this->log("Вход");
    }

    /**
     * Возвращает коллекцию авторизаций пользователя
     **/
    public function authorizations() {
        return Auth::all()->eq("userID", $this->id());
    }
    
    /**
     * Возвращает коллекцию авторизаций пользователя
     **/
    public function tokens() {
        return Token::all()->eq("userId", $this->id());
    }

    /**
     * Проверяет, может ли пользователь выполнить операцию $operation с парамтерами $params
     **/
    public final function checkAccess($operationCode, $params = array()) {
    
        Core\Profiler::beginOperation("user", "checkAccess", $operationCode);
    
        if(!is_array($params)) {
            throw new \Exception("user::checkAccess() second argument must be array");
        }
    
        $this->clearErrorText();
        $operation = Operation::get($operationCode);
        $ret = $operation->checkAccess($this,$params);
        
        if(!$this->errorText()) {
            $this->setErrorText("Операция {$operationCode} отклонена");
        }        
        
        Core\Profiler::endOperation();
        
        return !!$ret;
    }

    /**
     * Проверяет возможность выполнить операцию.
     * Если в доступе отказано, выкидывает Исключение
     **/
    public function checkAccessThrowException($operationCode, $params = array()) {   
        if(!$this->checkAccess($operationCode, $params)) {
            throw new Exception($this->errorText());
        }
    }
    
    public function clearErrorText() {
        $this->errorText = "";
    }    
   
    public function setErrorText($errorText) {
        if(trim($errorText)) {
            $this->errorText = $errorText;
        }
        return $this;        
    }
    
    public function errorText() {
        return $this->errorText;
    }

    private $roles = null;

    /**
     * Возвращает массив ролей данного пользователя
     **/
    public function roles() {

        Core\Profiler::beginOperation("user","roles",1);

        $rolesCodeList = $this->rolesAttached()->distinct("role");
        $roles = Role::all()->eq("code",$rolesCodeList);

        Core\Profiler::endOperation();

        return $roles;
    }

    public function addRole($role) {

        if(!$role) {
            throw new \Exception("Void role");
        }

        if($this->rolesAttached()->eq("role", $role)->void()) {
            $this->rolesAttached()->create(array(
                "role" => $role,
            ));
        }
    }

    public function removeRole($role) {
        $this->rolesAttached()
            ->eq("role", $role)
            ->delete();
    }
    
    public function rolesAttached() {
        return RoleAttached::all()->eq("userId", $this->id());
    }

     /**
     * Проверяет есть ли роль у юзера по коду
     **/
    public function hasRole($roleCode) {
        if(!is_string($roleCode)) {
            throw new Exception("user::hasRole() first argument must be a string");
        }
        
        return !$this->rolesAttached()->eq("role",$roleCode)->void();
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

    /**
     * Проверяет пароль на соответствие требованиям безопасности (минимальная длина и т.п.)
     * Проверкой пароля конкретного пользователя этот метод не занимается
     * @todo вынести в настройки минимальную длину пароля
     **/
    public static final function checkAbstractPassword($password) {
        $password = trim($password);
        $passlen = 5;
        if($passlen < 1) {
			$passlen = 1;
		}
        if(strlen($password) < $passlen) {
            app()->msg("Слишком короткий пароль. Минимальное количество символов: $passlen",1);
            return false;
        }
        return $password;
    }

    public function extra($key = null, $val = null) {
    
        if(func_num_args() == 0) {
            return $this->pdata("extra");
        }
    
        $extra = $this->pdata("extra");
        
        if(func_num_args() == 1) {
            return $extra[$key];
        }
        
        if(func_num_args() == 2) {
            $extra[$key] = $val;
            $this->data("extra", json_encode($extra));
        }
    }

    /**
     * Возвращает значение поля пользователя или результат выполнения
     * соответствующего метода поведений
     **/
    private final function fieldOrBehaviour($key) {
    
        $val = trim($this->data($key));
        if($val) {
            return $val;
        }

        foreach($this->behaviourMethods($key) as $fn) {
            if($val = trim($fn())) {
                return $val;
            }
        }
    }

    /**
     * Возвращает электронную почту пользователя
     **/
    public function email() {
        return $this->data("email");
    }

    /**
     * Возвращает телефон
     **/
    public function phone() {
        return $this->fieldOrBehaviour("phone");
    }

    /**
     * Возвращает имя пользователя
     * Вернет значения из поля "firstName" или информацию из поведений, если в поле пусто
     **/
    public function firstName() {
        return $this->fieldOrBehaviour("firstName");
    }

    /**
     * Возвращает фамилию польщователя
     * Вернет значения из поля "lastName" или информацию из поведений, если в поле пусто
     **/
    public function lastName() {
        return $this->fieldOrBehaviour("lastName");
    }

    /**
     * Возвращает ник пользователя
     * Вернет значения из поля "nickName" или информацию из поведений, если в поле пусто
     **/
    public function nickName() {
        return $this->fieldOrBehaviour("nickName");
    }

    /**
     * Возвращает город пользователя
     * Вернет значения из поля "city" или информацию из поведений, если в поле пусто
     **/
    public function city() {
        return $this->fieldOrBehaviour("city");
    }

    /**
     * Возвращает регион пользователя
     * Вернет значения из поля "region" или информацию из поведений, если в поле пусто
     **/
    public function region() {
        return $this->fieldOrBehaviour("region");
    }

    /**
     * Возвращает страну пользователя
     * Вернет значения из поля "country" или информацию из поведений, если в поле пусто
     **/
    public function country() {
        return $this->fieldOrBehaviour("country");
    }
    
	public function _userpic() {
	    return $this->pdata("userpic");
	}

    /**
     * Системная функция
     * Вызывается когда пользователь просматривает страницу
     **/
    public function registerActivity() {
        // Округляем время до 5 минут и записываем в пользователя
        $stamp = util::now()->stamp();
        $stamp = round($stamp / 60 / 5) * 60 * 5;
        $this->data("lastActivity", $stamp);
    }
    
    /**
     * Проверяет пароль $pass для данного поьбзователя
     * Возвращает true/false
     **/
    public function checkPassword($pass) {
        $check = Core\Crypt::checkHash($this->data("password"),$pass);
        return $check;
    }

    /**
     * Возвращает имя пользователя
     * Используется никнейм, если он задан
     * Если нет никнейма используется почта
     **/
    public function recordTitle() {

		if($r = $this->nickName()) {
            return $r;
        }

        if($r = $this->data("email")) {
            return $r;
        }

        return "user-".$this->id();
    }
    
    /**
     * $params = array(
     *   "type" => ...,
     *   "expires" => ...,
     * );
     **/
    public function generateToken($params) {    
        $token = service("ar")->create(Token::inspector()->className(), array(
            "userId" => $this->id(),
            "expires" => $params["expires"],
            "type" => $params["type"],
        ));
        return $token->token();
    }
    
    public function checkToken($token, $params) {
    
        $tokenObj = \Infuso\User\Model\Token::byToken($token);
        if(!$tokenObj->exists()) {
            return false;
        } 
        
        if(!$tokenObj->checkToken($token)) {
            return false;
        }
        
        if($tokenObj->expired()) {
            return false;
        }
        
        if($tokenObj->data("type") != $params["type"]) {
            return false;
        }
        
        return true;
    
    }

}
