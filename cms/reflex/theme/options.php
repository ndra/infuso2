<?

$editor = $collection->editor();

<form class='EIvwPQRUtU' >

    <div class='top' >

        foreach($editor->item()->fields() as $field) {
            if($field->visible()) {
                <div class='filter-item' >
                    <div class='left' >
                        echo $field->label();
                    </div>
                    <div class='right' >
                        $view = \Infuso\CMS\Reflex\FieldView\View::get($field);
                        $view->filterTemplate()
                            ->param("value", $filters[$field->name()])
                            ->exec();
                    </div>
                </div>
            }

        }
    
    </div>
    <div class='bottom' >
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->text("Применить фильтр")
            ->addClass("apply-filter")
            ->exec();
    </div>

</form>
