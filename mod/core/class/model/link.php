<?

namespace Infuso\Core\Model;
use infuso\util\util;
use Infuso\ActiveRecord\Record as Record;
use Infuso\Core;

class Link extends Field {


    public function typeID() {
        return "pg03-cv07-y16t-kli7-fe6x";
    }

    public function typeName() {
        return "Внешний ключ";
    }

    public function mysqlType() {
        return "bigint(20)";
    }

    public function mysqlIndexType() {
        return "index";
    }

    public function pvalue() {
        if(trim($this->param("foreignKey"))) {
            return service("ar")
                ->get($this->itemClass())
                ->eq(trim($this->param("foreignKey")),$this->value())
                ->one();
        } else {
            return service("ar")
                ->get($this->itemClass(),$this->value());
        }
    }

    /**
     * возвращает имя поля внешнего ключа для связи, если оно не задано используется id
     **/     
    public function foreignKey() {
        if(trim($this->param("foreignKey"))){
            return trim($this->param("foreignKey"));
        } else {
            return "id";
        }
    }

    public function rvalue() {
        return $this->pvalue()->title();
    }

    public function prepareValue($val) {
        return intval($val);
    }

    public function items() {

        $fn = trim($this->param("collection"));

        if($fn) {
            return $this->reflexItem()->$fn();
        }

        $items = service("ar")->collection($this->itemClass())->limit(100);
        
        return $items;
    }

    /**
     * Возвращает имя класса объектов
     **/
    public function itemClass($class=null) {
        return $this->param("class");
    }

    public function className() {
        return call_user_func_array(array($this,"itemClass"),func_get_args());
    }

}
