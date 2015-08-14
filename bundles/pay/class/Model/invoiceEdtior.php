<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 07.08.2015
 * Time: 17:02
 */

namespace Infuso\Pay\Model;
use Infuso\Core;

class InvoiceEdtior extends \Infuso\Cms\Reflex\Editor
{

    public function itemClass() {
        return Invoice::inspector()->className();
    }

    public function beforeEdit() {
        return Core\Superadmin::check();
    }

    /**
     * @reflex-root = on
     **/
    public function all() {
        return Invoice::all()->title("Счета")->param("tab","system");
    }
}