<?

$editor = $collection->editor();

<form class='EIvwPQRUtU' >

    <div class='top' >

        foreach($editor->fields() as $field) {
            if($field->field()->visible()) {
                <div class='filter-item' >
                    <div class='left' >
                        echo $field->field()->label();
                    </div>
                    <div class='right' >
                        $field->filterTemplate()
                            ->param("value", $filters[$field->field()->name()])
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
