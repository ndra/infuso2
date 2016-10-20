<?

namespace Infuso\Core;

/**
 * Класс, реализующий паттерн "Поведение"
 **/
class Behaviour {

	/**
	 * При помощи этой функции вы можете прикрепить это поведение как стандартное к любому классу.
	 * @return string Класс, к которому вы хотите приеркпить поведение
	 **/
	public static function addToClass() {
		return null;
	}

	/**
	 * @return float Приоритет поведения
	 * Поведения с более высоким приоритетам просматриваются в первую очередь
	 **/
	public static function behaviourPriority() {
		return 0;
	}
    
    private final function __construct() {
        throw new \Exception("Cannot instantiate behaviour");
    }

}
