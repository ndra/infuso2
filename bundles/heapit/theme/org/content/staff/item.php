<? 

$item = $occ->pdata("occId");
<tr class="item">
    <td>
        <div class='fio'><a href="{$item->url()}">{$item->title()}</a></div>
    </td>
    <td>
        <div class='email'><a href="mailto:{$item->data('email')}">{$item->data('email')}</a></div>
    </td>
    <td>
        <div class='phone'>{$item->data('phone')}</div>    
    </td>
    <td>
        /*$w = new \Infuso\Heapit\Widget\Button();
        $w->tag("button");
        $w->addClass("delete");
        $w->addClass("no-border");
        $w->attr("data:occId", $occ->id());
        $w->param("icon", $this->bundle()->path()."/res/img/staff/delete.png");
        $w->exec(); */   
    </td>
</tr>