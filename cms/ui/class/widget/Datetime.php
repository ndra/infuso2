<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 17.08.2015
 * Time: 11:07
 */

namespace Infuso\Cms\UI\Widgets;


class Datetime extends Textfield
{
    public function name() {
        return "Датавремя с календарем";
    }


    public function execWidget() {

        $this->app()->tm()
            ->exec("/ui/widgets/datetime",array (
                "widget" => $this,
            ));
    }
}