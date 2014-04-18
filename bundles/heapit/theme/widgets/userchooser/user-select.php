<? 
<div class="user-select-zaqfrsj6nf" >
    foreach(\Infuso\User\Model\User::all()->withRole("heapit:manager")->limit(0) as $user){
        $str = $user->data("userpick");
        <div class="item" user:id="{$user->id()}">
            <img src="$str">
            <div>{$user->title()}</div>
        </div>    
    }
        $zombie = $this->bundle()->path()."/res/img/widgets/UserChooser/zombie.png";
        <div class="item" user:id="0">
            <img src="$zombie">
            <div>Зомби-юзер</div>
        </div>    
</div>