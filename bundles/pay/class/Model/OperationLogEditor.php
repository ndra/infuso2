<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 13.08.2015
 * Time: 15:35
 */

namespace Infuso\Pay\Model;
use Infuso\Core;


class OperationLogEditor extends \Infuso\Cms\Reflex\Editor
{
    public function itemClass() {
        return OperationLog::inspector()->className();
    }

    public function beforeEdit() {
        return Core\Superadmin::check();
    }


}