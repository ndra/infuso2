<? 
<div class="user-select-zaqfrsj6nf" >
    foreach(user::all() as $user){
        $str = $user->data("userpick");
        <img class="item" user:id="{$user->id()}" src="$str">
    }    
</div>