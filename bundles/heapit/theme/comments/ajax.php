<? 

exec("/ui/shared");

<div class='comments-nni5vez0qz' >
    foreach($comments as $comment) {
        $owner = $comment->pdata("author");
        $userpick = $owner->pdata("userpic")->preview(16,16)->crop();
        <table class='item' >
            <tr class='head' >
                <td><img src='$userpick' /></td>
                <td style="width:100%;">
                    <span class="userName">{e($owner->title())}</span>
                    <span class="date">{$comment->pdata("datetime")->num()}</span>
                </td>
                <td>
                    <div class='edit' data:id='{$comment->id()}' ></div>
                </td>
            </tr>
            <tr class='body' >
                <td></td>
                <td style="width:100%;">{e($comment->data("text"))}</td>
            </tr>
        </table>
    }
</div>