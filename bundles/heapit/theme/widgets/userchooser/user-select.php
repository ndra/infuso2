<? 
<div class="user-select-zaqfrsj6nf" userchooser:name='{$fieldName}'>
    foreach(user::all() as $user){
        $str = "/mod".$user->data("userpick");
        <img class="item" user:id="{$user->id()}" src="$str">
    }    
</div>