<?

namespace Infuso\Heapit;
use \Infuso\Core;

/**
 * Стандартная тема для heapit
 **/

class Utils {

    /**
     * @return Возвращает стоимость в денежном формате - с ддвумя знаками после запятой и пробелами в цифрах
     */
    public static function formatPrice($price) {
        return number_format($price,0,"",$price>9999 ? "&nbsp;" : "");
    }

}
