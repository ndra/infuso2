<? 
<div class="user-select-zaqfrsj6nf" >

    foreach(\Infuso\User\Model\User::all()->withRole("heapit:manager")->limit(0) as $user){
        $str = $user->userpic()->preview(100,100)->crop();
        <div class="item" user:id="{$user->id()}">
            <img src="$str">
            <div class='name' >{$user->title()}</div>
        </div>    
    }
    
    <div class="item" user:id="0">
        <img src="{$anonymousUserpic}" class='userpic' />
        <div class='name' >{$anonymousName}</div>
    </div> 
       
</div>