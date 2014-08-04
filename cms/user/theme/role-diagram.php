<?

lib::jsplumb();

<div class='sze6eaja0l' >

    $showOperation = function($operation) use (&$showOperation) {
        
        $key = "node".$operation->id();
        if($this->param($key)) {
            return;
        }
        $this->param($key,true);
        
        <table>
            <tr>
                $editor = \Infuso\Cms\Reflex\Editor::get("Infuso\\Cms\\User\\OperationEditor:".$operation->id());
                <td>
                
                    $h = helper("<a>")
                        ->attr("href", $editor->url())
                        ->addClass("node")
                        ->param("content", $operation->title());
                    
                    $parents = array();
                    foreach($operation->parentOperations() as $parent) {
                        $parents[] = $parent->id();
                    }
                    $parents = implode(" ",$parents);
                    $h->attr("data:parents",$parents);
                    
                    $h->attr("id","operation-".$operation->id());
                    $h->exec();
                    
                </td>
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