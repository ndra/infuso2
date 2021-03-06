<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Point extends StringX {

    public function typeID() {
        return "opu03";
    }

    public function typeName() {
        return "Точка";
    }
    
    public function typeAlias() {
        return array("point", "coords");
    }

    public function mysqlType() {
        return "Point";
    }

    public function mysqlNull() {
        return true;
    }

    public function prepareValue($val) {

        if(is_object($val)) {
            $val = $val->value();
        }

        if(is_array($val)) {
            if(array_key_exists("x",$val) && array_key_exists("y",$val)) {
                $val = $val["x"].",".$val["y"];
            } else {
                $val = $val[0].",".$val[1];
            }
        }

        if(is_string($val)) {
            if(preg_match("/^\s*\-?\s*(\d+(\.\d+)?)\s*\,\s*\-?\s*(\d+(\.\d+)?)$/",$val)) {
                $val = explode(",",$val);
                $val = pack('xxxxcLdd', '0', 1, $val[0],$val[1]);
                return $val;
            }
        }

        if(trim($val) == "") {
            return null;
        }

        return $val;

    }

    /**
     * Возвращает x-координату точки (долготу)
     **/
    public function x() {
        $pval = $this->pvalue();
        $x = $pval["x"];
        if(!$x) {
            $x = 0;
        }
        return $x;
    }
    
    /**
     * Возвращает долготу
     **/
    public function lng() {
        return $this->x();
    }

    /**
     * Возвращает y-координату точки (широту)
     **/
    public function y() {
        $pval = $this->pvalue();
        $y = $pval["y"];
        if(!$y) {
            $y = 0;
        }
        return $y;
    }

    /**
     * Возвращает широту
     **/
    public function lat() {
        return $this->y();
    }

    /**
     * Возвращает типизированное значение поля: массив [x,y]
     **/
    public function pvalue() {
        $ret = @unpack('x/x/x/x/corder/Ltype/dx/dy', $this->value());
        if(!$ret) {
            $ret = array();
        }
        return $ret;
    }

    /**
     * Возвращает текстовое значение поля: строку "x,y"
     * Если значение поля == null, возвращаем пустую строку
     **/
    public function rvalue() {

        if($this->value() == null) {
            return "";
        }

        return $this->x().",".$this->y();
    }

    public function mysqlValue() {

        if($this->value() == null) {
            return "null";
        }

        $x = $this->x();
        $y = $this->y();
        $val = "GeomFromText('POINT($x $y)')";

        return $val;
    }

}
