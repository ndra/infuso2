<?

namespace Infuso\User;
use \Infuso\Core;

class Service extends Core\Service {
 
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
        return Model\User::get($id);
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
        $deleteTime = util::now()->shiftDay(-$this->param("deleteUnverfiedUserDays"));
        $users = $this->unverfiedUsers()->lt("registrationTime", $deleteTime);
        $users->delete();
    }
    
}
