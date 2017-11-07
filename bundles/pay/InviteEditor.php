<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class InviteEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Invite::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/
    public function all() {
        return Invite::all()->title("Приглашения");
    }

}