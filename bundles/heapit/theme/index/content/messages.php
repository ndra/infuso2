<?

<div class='rj7v5kdbu' >

    <h2>Прямой эфир:</h2>
    exec("/ui/shared");
    
    foreach(\Infuso\Heapit\Model\Comment::all() as $comment) {
        
        $date = $comment->pdata("datetime")->date()->text();
        if($date != $lastDate) {
            <div class='date' >{$date}</div>
        }
        $lastDate = $date;
        
        $owner = $comment->pdata("author");
        $userpick = $owner->pdata("userpic")->preview(16,16)->crop();
        <div class='comment' >
            <div class='user-date' >
                <span class="time" >{$comment->pdata("datetime")->format("H:i")}</span>
                <img src='$userpick' />
                <span class="user">{e($owner->title())}</span>
            </div>
            <div>
                echo e($comment->data("text"));
            </div>
        </div>
    }

</div>

