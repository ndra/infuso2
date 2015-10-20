<?

namespace Infuso\Poll\Model;

/**
 * Редактор ответа на вопрос
 **/
class AnswerEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Answer::inspector()->className();
    }

}