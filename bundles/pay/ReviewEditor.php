<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class ReviewEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Review::inspector()->className();
    }

    /**
     * @reflex-root = on
	 *  @reflex-group = Отзывы
     **/
    public function all() {
        return Review::all()->asc("verified")->title("Отзывы");
    }
	
	public function listItemTemplate() {
        return app()->tm("/site/admin/review-list-item")
            ->param("editor", $this);
    }

}