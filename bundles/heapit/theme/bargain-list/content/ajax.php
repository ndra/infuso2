<? 

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
                    <td><a href='{$bargain->url()}' target='_blank' >{$bargain->id()}</a></td>
                    
                    // Время созвона
                    
                    <td class='callTime' >
                        if(!$bargain->closed()) {
                            $h = helper("<span>");                        
                            if(\util::now()->date()->stamp() > $bargain->pdata("callTime")->stamp()) {
                                $h->addClass("expired");
                            }  
                            if(\util::now()->date()->stamp() == $bargain->pdata("callTime")->stamp()) {
                                $h->addClass("today");
                            }    
                            $h->begin();
                                echo $bargain->pdata("callTime")->left();
                            $h->end();
                        }
                    </td>
                    
                    // Организация                
                    <td class='org' >
                        <a href='{$bargain->org()->url()}' target='_blank' >{$bargain->org()->title()}</a>
                    </td>
                    
                    // Описание сделки
                    <td>
                        <a href='{$bargain->url()}' target='_blank' >{$bargain->data("description")}</a>
                    </td>
                    
                    // Сумма
                    <td>{\Infuso\Heapit\Utils::formatPrice($bargain->data("amount"))}</td>
                    
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
                            <span class='date' >{$comment->pdata("datetime")->left()}</span>
                            echo $comment->data("text");
                        </td>
                    </tr>
                }
            </tbody>
        }
    </table>
    
</div>