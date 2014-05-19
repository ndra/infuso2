<? 

<div class='x0kf50uz479' >
    <table>
    
        <thead>
            <tr>
                foreach($collection->editor()->fields() as $field) {
                    if($field->field()->visible()) {
                        <td style='width:{$field->colWidth()}px;' >{$field->field()->label()}</td>
                    }
                }
            </tr>
        </thead>
    
        foreach($collection->editors() as $editor) {
            $item = $editor->item();
            <tr class='list-item' data:id='{$editor->id()}' >
                foreach($item->fields() as $field) {
                    if($field->visible()) {
                        <td>{$field->rvalue()}</td>
                    }
                }
            </tr>
        }
    </table>
</div>