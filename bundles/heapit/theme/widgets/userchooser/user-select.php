<? 
<div class="user-select-zaqfrsj6nf" >
    foreach(user::all()->neq("nickName", "")->limit(0) as $user){
        $str = $user->data("userpick");
        <div class="item" user:id="{$user->id()}">
            <img src="$str">
            <div>{$user->data("nickName")}</div>
        </div>    
    }    
</div>