<? 

<div class='bargain-list-uluetdzzol' >

    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>Когда связаться</td>
                <td>Последний комментарий</td>
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
                <td class='callTime' >{$bargain->pdata("callTime")->left()}</td>                
                <td class='lastComment' >{$bargain->pdata("lastComment")->left()}</td>
                <td class='org' ><a href='{$bargain->org()->url()}' >{$bargain->org()->title()}</a></td>
                <td><a href='{$bargain->url()}' >{$bargain->data("description")}</a></td>
                <td>{$bargain->data("amount")}</td>
                <td>
                    echo $bargain->pdata("status");
                    if($bargain->data("status") == \Infuso\Heapit\Model\Bargain::STATUS_REFUSAL) {
                        echo "&#92;".$bargain->pdata("refusalDescription");   
                    }
                </td>
                <td style='text-align: center;'>
                    $preview = $bargain->responsibleUser()->userpic()->preview(40,40)->crop();
                    <img src="{$preview}" >
                </td>
            </tr>
            <tr>
                <td colspan=3>
                <td colspan='100' class='comment' >                
                    $comment = $bargain->comments()->one();
                    $userpic = $comment->author()->userpic()->preview(16,16)->crop();
                    <img class='comment-author' src='{$userpic}' align='absmiddle' />
                    echo $comment->data("text");
                </td>
            </tr>
        }
    </table>
    
</div>