<?

$editor = $collection->editor();

<form class='EIvwPQRUtU' >

    <div class='top' >

        foreach($editor->item()->fields()->visible() as $field) {
                
            $view = \Infuso\CMS\Reflex\FieldView\View::get($field);
            $filter = $view->filterTemplate();
                
            if($filter) {
                <div class='filter-item' >
                    <div class='left' >
                        echo $field->label();
                    </div>
                    <div class='right' >
                        $filter
                            ->param("value", $filters[$field->name()])
                            ->exec();
                    </div>
                </div>
            }
            
        }
        
        foreach($editor->item()->fields()->visible() as $field) {
            if($field->typeId() == "pg03-cv07-y16t-kli7-fe6x") {
                
                <div style='border-top: 1px solid #ededed;padding: 10px 0; font-weight: bold;' >{$field->label()}</div>
                
                $className = $field->className();
                $item = new $className();
                foreach($item->fields()->visible() as $subfield) {
                    $view = \Infuso\CMS\Reflex\FieldView\View::get($subfield);
                    $filter = $view->filterTemplate();
                        
                    if($filter) {
                        <div class='filter-item' >
                            <div class='left' >
                                echo $subfield->label();
                            </div>
                            <div class='right' >
                            
                                $name = $field->name()."@$#%^&*".$subfield->name();
                            
                                $filter
                                    ->param("name", $name)
                                    ->param("value", $filters[$name])
                                    ->exec();
                            </div>
                        </div>
                    }   
                }
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
