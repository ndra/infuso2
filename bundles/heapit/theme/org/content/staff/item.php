<? 
$occ = $occ->pdata("occId");
<tr>
    <td>
        <div class='fio'><a href="{$occ->url()}">{$occ->title()}</a></div>
    </td>
    <td>
        <div class='email'><a href="{$occ->url()}">{$occ->data('email')}</a></div>
    </td>
    <td>
        <div class='phone'><a href="{$occ->url()}">{$occ->data('phone')}</a></div>    
    </td>
</tr>