<?

$menu = service("reflex")->root($tab);

<div class='ddw7fs4b37' >
    //<tr>
        <div class='left' >
            foreach(\Infuso\Cms\Reflex\Model\RootTab::all() as $rtab) {
                <div class='tab {$rtab->name() == $tab ? "active" : ""}' data:tab='{$rtab->name()}' style='background-image:url({$rtab->data("icon")});' ></div>
            }
        </div>
        <div class='center' >
            foreach($menu as $item) {
                <div>
                    $item->param("stored", $stored);
                    $item->exec();
                </div>
            }
        </div>
</div>