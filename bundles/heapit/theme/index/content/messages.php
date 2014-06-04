<?

<div class='rj7v5kdbu' >

    <h2>Прямой эфир:</h2>
    exec("/ui/shared");
    
    foreach(\Infuso\Heapit\Model\Comment::all() as $comment) {
        $owner = $comment->pdata("author");
        $userpick = $owner->pdata("userpic")->preview(16,16)->crop();
        <table class='item' data:id='{$comment->id()}' >
            <tr>
                <td><img src='$userpick'></td>
                <td style="width:100%;">
                    <span class="userName">{e($owner->title())}</span>
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

