<? 

foreach($bargains->copy()->limit(0) as $bargain) {
    $bargain->beforeStore();
}

<div class='bargain-list-uluetdzzol' >

    <table>
        <thead>
            <tr>
                <td class='id-head' >id</td>
                <td class='time-head' >Когда связаться</td>
                <td class='org-head' >Организация</td>
                <td class='descr-head' >Описание</td>
                <td class='amount-head' >Сумма</td>
                <td class='status-head' >Cтатус</td>
                <td class='responsible-head' >Ответственный</td>
            </tr>
        </thead>
        foreach($bargains as $bargain) {
            <tbody>
                <tr>
                    <td><a href='{$bargain->url()}' >{$bargain->id()}</a></td>
                    
                    <td class='callTime' >
                        if(!$bargain->closed()) {
                            $h = helper("<span>");                        
                            if(\util::now()->stamp() > $bargain->pdata("callTime")->stamp()) {
                                $h->addClass("expired");
                            }                
                            $h->begin();
                                echo $bargain->pdata("callTime")->left();
                            $h->end();
                        }
                    </td>
                                    
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
                
                $comment = $bargain->comments()->one();
                if($comment->exists()) {
                    <tr>
                        <td colspan=3>
                        <td colspan='100' class='comment' >                
                            
                            $userpic = $comment->author()->userpic()->preview(16,16)->crop();
                            <img class='comment-author' src='{$userpic}' align='absmiddle' />
                            echo $comment->data("text");
                        </td>
                    </tr>
                }
            </tbody>
        }
    </table>
    
</div>