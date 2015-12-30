<?

js($this->bundle()->path()."/res/js/sortable.min.js");

<div class='p7jBpDQmdS' >
    if($field->pvalue()->count() > 0) {
        foreach($field->pvalue() as $item) {
            <table data:id='{$item->id()}' class='item' >
                <tr>
                    <td class='sort-handle' ></td>
                    <td class='title' >
                        <a href='{$item->plugin("editor")->url()}' >
                            echo $item->title();
                        </a>
                    </td>
                    <td class='remove' ></td>
                </tr>
            </table>
        }
    } else {
        <div class='void' >Элементы не выбраны</div>
    }
</div>