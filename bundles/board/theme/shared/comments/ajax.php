<? 

<div class='NxEX1Vh7h0' >

    $lastDate = null;
    
    foreach($task->getlog() as $item) {
        
        $date = $item->pdata("created")->date()->text();
        
        if($date != $lastDate) {
            <div class='date' >{$date}</div>
        }
        
        $lastDate = $date;
        
        <table class='comment' >
            <tr>
                <td class='userpic' >
                    <img src='{$item->user()->userpic()->preview(16,16)->crop()}' />
                </td>
                <td class='user' >
                    <a href='{$item->user()->url()}' >{$item->user()->title()}</a>
                </td>
                <td class='type' >
                    <img src='{$item->icon16()}' />
                </td>
                <td class='text' >
                
                    $type = $item->pdata("type");
                    echo $type;

                    if($text = $item->text()) {
                        
                        if($type) {
                            echo ": ";
                        }
                        
                        $text = \util::str($text)->esc();
                        $text = nl2br($text);
                        echo $text;
                    }
                </td>
                <td class='time' >{$item->pdata("created")->format("H:i")}</td>
            </tr>
        </table>
    }

</div>