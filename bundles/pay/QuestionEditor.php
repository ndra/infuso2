<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class QuestionEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Question::inspector()->className();
    }

    /**
     * @reflex-root = on
	 * @reflex-group = Преподаватели 
     **/
    public function all() {
        return Question::all()->title("Вопросы преподавателям");
    }
    
    public function filters($collection) {
        return array(
            "Отвечено" => $collection->copy()->eq("completed",true),
            "Требует ответа" => $collection->copy()->eq("completed",false),
        );
    }
	
	public function listItemTemplate() {
        return app()->tm("/site/admin/question-list-item")
            ->param("editor", $this);
    }
	
}