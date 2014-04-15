<? 
//$occ = $occ->pdata("occId");
$item = $occ->pdata("occId");
<tr>
    <td>
        <div class='fio'><a href="{$item->url()}">{$item->title()}</a></div>
    </td>
    <td>
        <div class='email'><a href="{$item->url()}">{$item->data('email')}</a></div>
    </td>
    <td>
        <div class='phone'><a href="{$item->url()}">{$item->data('phone')}</a></div>    
    </td>
    <td>
        $w = new \Infuso\Heapit\Widget\Button();
        $w->tag("button");
        $w->addClass("delete");
        $w->attr("data:occId", $occ->id());
        $w->param("icon", $this->bundle()->path()."/res/img/staff/delete.png");
        $w->exec();    
    </td>
</tr>