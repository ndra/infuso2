<? 

<div class='bargain-list-uluetdzzol' >

    <table>
    <thead>
        <tr>
            <td>id</td>
            <td>Создано</td>
            <td>Организация</td>
            <td>Описание</td>
            <td>Сумма</td>
            <td>Cтатус</td>
            <td>Ответственный</td>
        </tr>
    </thead>
    foreach($bargains as $bargain) {
        <tr>
            <td><a href='{$bargain->url()}' >{$bargain->id()}</a></td>
            <td><a href='{$bargain->url()}' >{$bargain->pdata("created")->txt()}</a></td>
            <td><a href='{$bargain->url()}' >{$bargain->pdata("orgId")->title()}</a></td>
            <td><a href='{$bargain->url()}' >{$bargain->data("description")}</a></td>
            <td>{$bargain->data("amount")}</td>
            <td>
                echo $bargain->pdata("status");
                if($bargain->data("status") == \Infuso\Heapit\Model\Bargain::STATUS_REFUSAL){
                    echo "&#92;".$bargain->pdata("refusalDescription");   
                }
            </td>
            <td style='text-align: center;'>
                $preview = $bargain->pdata("userID")->pdata("userpick")->preview(40,40)->resize();
                <img src="$preview">
            </td>
        </tr>
    }
    </table>
    
</div>