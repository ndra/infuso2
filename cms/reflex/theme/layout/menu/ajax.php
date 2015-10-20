<?

$menu = service("reflex")->root($tab);

<table class='ddw7fs4b37' >
    <tr>
        <td class='left' >
            foreach(\Infuso\Cms\Reflex\Model\RootTab::all() as $rtab) {
                <div class='tab {$rtab->name() == $tab ? "active" : ""}' data:tab='{$rtab->name()}' style='background-image:url({$rtab->data("icon")});' ></div>
            }
        </td>
        <td class='right' >
            foreach($menu as $item) {
                <div>
                    $item->param("stored", $stored);
                    $item->exec();
                </div>
            }
        </td>
    </tr>
</table>