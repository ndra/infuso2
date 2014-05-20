<? 

<div class='sze6eaja0l' >

    $showOperation = function($operation) use (&$showOperation) {
        <table>
            <tr>
                $editor = \Infuso\Cms\Reflex\Editor::get("Infuso\\Cms\\User\\OperationEditor:".$operation->id());
                <td><a href='{$editor->url()}' >{$operation->title()}</a></td>
                <td>
                    foreach($operation->subOperations() as $sub) {
                        $showOperation($sub);
                    }
                </td>
            </tr>
        </table>
    };
    
    $collection = $collection->collection();
    foreach($collection->eq("role", 1) as $item) {
        $showOperation($item);
    }

</div>