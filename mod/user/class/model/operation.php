<?

namespace Infuso\User\Model;
use \Infuso\Core;
use \Infuso\ActiveRecord;

class Operation extends ActiveRecord\Record {

	private $idList = null;

    private $errorText = null;

    private $parents = null;

	public static function model() {
		return array(
			'name' => 'user_operation',
			'fields' => array(
				array(
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'editable' => '1',
				),
				array(
					'name' => 'title',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
				),
				array(
					'name' => 'code',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'id' => '0qm92jygrj8gs34aso8vhqmazoce2d',
					'label' => 'Код',
					'indexEnabled' => 0,
				),
				array(
					'name' => 'business-logic',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'editable' => '1',
					'label' => 'Бизнес-логика (php)',
					'indexEnabled' => 0,
				),
				array(
					'editable' => 1,
					'name' => 'parents',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'label' => 'Родительские операции',
					'indexEnabled' => 1,
				),
				array(
					'editable' => 2,
					'name' => 'role',
					'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
					'indexEnabled' => 1,
				),
			),
		);
	}

    /**
     * Возвращает коллекцию всех операций
     **/
    public static function all() {
        return \reflex::get(get_class())->limit(0);
    }

    /**
     * @return Возвращает операцию по id
     * Если операция не найдена, возвращает виртуальный объект с заданным полем `code`
     **/
    public static function get($code) {
        $ret = self::all()->eq("code",$code)->one();
        if(!$ret->exists()) {
            $ret = Core\Mod::app()->service("ar")->virtual(get_class(),array(
                "code" => $code,
            ));
        }
        return $ret;    
    }
    
    public function recordTitle() {
        $ret = $this->data("title");
        if(!$ret) {
            $ret = $this->code();
        }
        return $ret;
    }
    
    /**
     * Возвращает коллекцию дочерних операций
     **/
    public function subOperations() {

        if($this->idList===null) {
            $this->idList = array();
            foreach(Operation::all()->limit(0) as $op) {
                $roles = explode(" ",$op->data("parents"));
                if(in_array($this->code(),$roles)) {
                    $this->idList[] = $op->id();
                }
            }
        }

        return Operation::all()->eq("id",$this->idList);
    }
    
    /**
     * Создает новую операцию
     **/
    public static function create($code,$title="") {
        return service("ar")->create(get_class(),array(
            "code" => $code,
            "title" => $title,
        ));
    }
    
    /**
     * Добавляет бизнес-правило
     **/
    public function addBusinessRule($code) {
        $rules = $this->data("business-logic");
        $rules.= "\n".$code;
        $this->data("business-logic",$rules);
        return $this;
    }
    
    /**
     * Возвращает массив (!) родительских операций
     **/
    public function parentOperations() {

        if($this->parents===null) {
            $this->parents = array();
            foreach(\util::splitAndTrim($this->data("parents")," ") as $operationCode) {
                $this->parents[] = Operation::get($operationCode);
            }
        }
        
        return $this->parents;
    }
    
    public function code() {
        return $this->data("code");
    }
    
    /**
     * Прикрепляет операцию к родительской операции
     **/
    public function appendTo($operation) {
        $operations = \util::splitAndTrim($this->data("parents")," ");
        $operations[] = $operation;
        $operations = array_unique($operations);
        $this->data("parents",implode(" ",$operations));
        return $this;
    }
    
    /**
     * Если вызвано в бизнес-правиле, вызывает ошибку проверки права
     **/
    public function error($errorText) {
        throw New Exception($errorText);
    }
    
    /**
     * Возвращает текст последней ошибки
     **/
    public function getLastError() {
        return $this->errorText;
    }
    
    /**
     * Проверяет доступ пользователя к жанной операции
     **/
    public function checkAccess($user,$params) {

        $this->errorText = "";
    
        // Попытка проверить несуществующее правило не удастся
        if(!$this->exists()) {
            return false;
        }

        $ret = false;
        
        if(\infuso\core\superadmin::check() && $this->data("role")==true) {
            $ret = true;
        }

        // Роль "Гость" есть у каждого пользователя
        if(!$ret) {
            if($this->code()=="guest") {
                $ret = true;
            }
        }

        // Проверяем наличие у пользователя этой роли

        if(!$ret) {
            foreach($user->roles() as $role) {
                if($role->code()==$this->code()) {
                    $ret = true;
                    break;
                }
            }
        }
        
        // Проверяем наличие у пользователя роли, к которым прикреплена операция
        if(!$ret) {
            foreach($this->parentOperations() as $operation) {
                if($user->checkAccess($operation->code(),$params)) {
                    $ret = true;
                    break;
                }
            }
        }

        if(!$ret) {
            return false;
        }

        // Если заданы бизнес-правила, выполняем их
        // Если не заданы (пустая строка), считаем что бизнес-правила выполнены успешно
        try {
        
            if($this->data("business-logic") != "") {
            
                foreach($params as $key=>$val) {
                    $$key = $val;
                }
            
                $error = Core\Superadmin::check() ? "Не указано возвращаемое значение в бизнес-правилах операции <b>{$this->code()}</b>" : "";
                
                $php = $this->data("business-logic");
                $php.= "\n".'$this->error("'.$error.'");';
                
                $ret = eval($php);
                if(!$ret) {
                    return false;
                }
            }
            
        } catch(Exception $exception) {
            $this->errorText = $exception->getMessage();
            $user->setErrorText($this->getLastError());
            return false;
        }
        
        return true;
        
    }

}
