<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 11.08.2015
 * Time: 14:40
 */

namespace Infuso\Pay\Model;
use Infuso\Core;

class RateEditor extends \Infuso\Cms\Reflex\Editor
{
    public function itemClass() {
        return Rate::inspector()->className();
    }

    public function beforeEdit() {
        return Core\Superadmin::check();
    }

    /**
     * @reflex-root = on
     **/
    public function all() {
        return Rate::all()->param("title","Курсы валют")->param("tab","system");
    }
}