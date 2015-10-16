<?

namespace Infuso\Cms\Reflex;

/**
 * Модель-заглушка
 * используется при попытке создать объект несуществующего класса
 **/
class NoneEditor extends Editor {

	public function itemClass() {
		return "reflex_none";
	}

}
