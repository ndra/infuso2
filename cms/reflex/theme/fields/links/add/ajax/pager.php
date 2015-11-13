<?

$page = $collection->page();
$pages = $collection->pages();

if($pages > 1) {

    <div class='xMgMgMvtp1' >
        <div class='pager' >
            if($page>1) {
                <span style='font-weight:normal;' data:page='1'>&laquo;</span>
                <span style='font-weight:normal;' data:page='{$page - 1}' >&lsaquo;</span>
            }
            for($i = $page - 10; $i <= $page + 10; $i++)
                if($i >= 1 & $i <= $pages) {
                    if($page==$i) {
                        <span class='active' data:page='{$i}' >$i</span>
                    } else {
                        <span data:page='{$i}' >{$i}</span>
                    }
                }
            if($page < $pages) {
                <span style='font-weight:normal;' data:page='{$page + 1}' >&rsaquo;</span>
                <span style='font-weight:normal;' data:page='{$pages}' >&raquo;</span>
            }
        </div>
        
    </div>

}
