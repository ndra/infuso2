<? 

<div class='uluetdzzol' >

    <table>
    foreach($bargains as $bargain) {
        <tr>
            <td>{$bargain->id()}</td>
            <td>{$bargain->pdata("created")->txt()}</td>
            <td>{$bargain->pdata("orgId")->title()}</td>
            <td><a href='{$bargain->url()}' >{$bargain->data("description")}</a></td>
            <td>{$bargain->data("amount")}</td>
            <td>{$bargain->pdata("status")}</td>
        </tr>
    }
    </table>
    
</div>