<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class TicketTypeEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return TicketType::inspector()->className();
    }
    
}