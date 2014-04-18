<? 

<div class='comments-nni5vez0qz' >
    foreach($comments as $comment) {
        $owner = $comment->pdata("author");
        $userpick = $owner->pdata("userpick")->preview(16,16)->resize();
        <table>
            <tr>
                <td><img src='$userpick'></td>
                <td style="width:100%;">
                    <span class="userName">{e($owner->data("email"))}</span>
                    <span class="date">{$comment->pdata("datetime")->num()}</span>
                </td>
                            
            </tr>
            <tr>
                <td></td>
                <td style="width:100%;">{e($comment->data("text"))}</td>
                         
            </tr>
        </table>
    }
</div>