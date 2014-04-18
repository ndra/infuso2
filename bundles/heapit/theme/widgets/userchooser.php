<?

<div class="userChooser-r5rr523ugt">
    $user = \user::get($userID);
    if($user->exists()){
        $path = $user->data("userpick");
    }else{
        $path = $this->bundle()->path()."/res/img/widgets/UserChooser/emptyUser.png";    
    } 
    <div class="currentUser">
        <img  src='$path'>
        <div class="currentUserNickname"></div>
    </div>    
    exec("user-select");
    <input type='hidden' class='user-select-hiddenField' name='{$fieldName}' value='{$userID}'>
</div>