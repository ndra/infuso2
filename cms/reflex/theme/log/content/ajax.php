<? 

<div class='p3sldjrnyq' >    
    $items = $editor->item()->plugin("log")->all();
    
    <table>
        foreach($items as $item) {
            <tr>
                <td>{$item->pdata("datetime")->num()}</div>
                <td>{$item->message()}</div>
            </tr>
        }
    </table>
    
</div>