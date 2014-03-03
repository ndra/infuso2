<? 

$menu = mod::service("reflex")->root();

<div class='ddw7fs4b37' >
    foreach($menu as $item) {
        <div>
            $item->exec();
        </div>
    }
</div>