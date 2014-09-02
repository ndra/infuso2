<?

$collection = $collection->collection();

<div class='F32KKaOgV7' >
    
    $page = $collection->page();
    $pages = $collection->pages();
    
    if($pages!=1) {
    
        echo "<div class='pager' >";
        if($page>1) {
            <span style='font-weight:normal;' data:page='1'>&laquo;</span>
            <span style='font-weight:normal;' data:page='{$page - 1}' >&lsaquo;</span>
        }
        for($i = $page - 10; $i <= $page + 10; $i++)
            if($i >= 1 & $i <= $pages) {
                if($page==$i) {
                    <span style='color:red;' data:page='{$i}' >$i</span>
                } else {
                    <span data:page='{$i}' >{$i}</span>
                }
            }
        if($page < $pages) {
            <span style='font-weight:normal;' data:page='{$page + 1}' >&rsaquo;</span>
            <span style='font-weight:normal;' data:page='{$pages}' >&raquo;</span>
        }
        echo "</div>";
    }
    
</div>
