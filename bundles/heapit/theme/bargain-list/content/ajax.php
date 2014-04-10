<? 

<div class='uluetdzzol' >

    <table>
    foreach($bargains as $bargain) {
        <tr>
            <td>{$bargain->id()}</td>
            <td><a href='{$bargain->url()}' >{$bargain->data("description")}</a></td>
        </tr>
    }
    </table>
    
</div>