<?

<div class="userChooser-r5rr523ugt">
    $user = \user::get($userID);
    if($user->exists()){
        $path = $user->data("userpick");
    }else{
        $path = $this->bundle()->path()."/res/img/widgets/UserChooser/emptyUser.png";    
    } 
    
    <img class="currentUser" src='$path'>
    exec("user-select");
    <input type='hidden' class='user-select-hiddenField' name='{$fieldName}' value='{$userID}'>
</div>