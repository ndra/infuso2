<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Decimal extends Bigint {

	public function typeID() { return "yvbj-cgin-m90o-cez7-mv2j"; }
	
	public function typeName() { return "Дробное число"; }

	public function mysqlType() { return "double"; }
	
	public function mysqlIndexType() { return "index"; }
    
    public function typeAlias() {
        return array(
            "decimal",
        );
    }

	public function filterType() { return "number"; }

	public function prepareValue($val) {

		// Заменяем запятую на точку
		$val = strtr($val,array(
			","=>".",
		));

		// Вырезаем из строки лишние символы, особенно [:)] пробелы
		$val = preg_replace("/[^\d\.\-]/u","",$val);

		// Преобразуем смтроку в число
		$val = floatval($val);
		return $val;
	}

}
