<? 

<div class='fbknw356c6' >
    foreach($comments as $comment) {
        <table>
            <tr>
                <td>{$comment->id()}</td>
                <td>{e($comment->data("message"))}</td>
                <td></td>            
            </tr>
        </table>
    }
</div>