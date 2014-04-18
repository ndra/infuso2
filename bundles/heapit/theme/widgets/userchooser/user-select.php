<? 
<div class="user-select-zaqfrsj6nf" >
    foreach(\Infuso\User\Model\User::all()->withRole("heapit:manager")->limit(0) as $user){
        $str = $user->data("userpick");
        <div class="item" user:id="{$user->id()}">
            <img src="$str">
            <div>{$user->title()}</div>
        </div>    
    }    
</div>