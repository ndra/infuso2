<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 10:40
 */

namespace Infuso\Site\Model;
use Infuso\Core;

class simpleEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Simple::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/
    public function all() {
        return Simple::all()->eq("section", 0)->title("Отзывы");
    }

    /**
     * @reflex-root = on
     **/
    public function allClub() {
        return Simple::all()->eq("section", 1)->title("Отзывы клуба Brelil");
    }

}