<?


$page = $collection->page();
$pages = $collection->pages();

if($pages != 1) {

    <div class='pNrzLvP0As' >
    
        if($page > 1) {
            $url = $collection->url($page-1);
            <a  href='$url' >Предыдущая страница</a>
        }
        
        for($i = $page - 10; $i <= $page + 10; $i ++) {
            if($i >= 1 & $i <= $pages) {
                $href = $collection->url($i);
                if($page == $i) {
                    <a class="active" href='$href' >$i</a>
                } else {
                    <a href='$href' >$i</a>
                }
            }
        }
        
        if($page < $pages) {
            $url = $collection->url($page+1);
            <a  href='$url' >Следующая страница</a>
        }
        
    </div>
} 