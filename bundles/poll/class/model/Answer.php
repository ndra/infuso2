<?

namespace Infuso\Poll\Model;

/**
 * Модель ответа на вопрос
 **/
class Answer extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array (
            'name' => self::inspector()->className(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'pollId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'class' => Poll::inspector()->className(),
                ), array (
                    'name' => 'date',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => '2',
                    "default" => "now()",
                    'label' => 'Дата ответа',
                ), array (
                    'name' => 'optionId',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '2',
                    'label' => 'Данные голосования',
                    'class' => Option::inspector()->className(),
                ), array (
                    'name' => 'cookie',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '2',
                    'label' => 'Идентификатор cookie проголосовавшего',
                    'length' => '20',
                ),
            ),
        );
    } 

    public static function all() {
        return service("ar")
            ->collection(get_called_class())
            ->desc("date");
    }

    public static function get($id) {
        return service("ar")->get(get_called_class(), $id);
    }

    public function recordParent() {
        return $this->poll();
    }

    /**
     * @return Вариант ответа
     **/
    public function option() {
        return $this->pdata("optionId");
    }

    /**
     * @return Объект голосования
     **/
    public function poll() {
        return $this->pdata("pollId");
    }

    /*public function reflex_afterOperation() {
        mod::fire("vote_answersChanged",array(
            "vote" => $this->vote(),
            "answer" => $this,
            "option" => $this->option(),
        ));
    } */

}
