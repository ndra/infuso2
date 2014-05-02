<? 

<div class='p3sldjrnyq' >    
    $items = $editor->item()->plugin("log")->getLog();
    
    <table>
        foreach($items as $item) {
            <tr>
                <td>{$item->pdata("datetime")->num()}</div>
                <td>{$item->text()}</div>
            </tr>
        }
    </table>
    
</div>