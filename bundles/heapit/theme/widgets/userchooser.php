<?
<div class="userChooser-r5rr523ugt">
    $user = \user::get($userID);
    if($user->exists()){
        $path = $user->userpick();
    }else{
        $path = $this->bundle()->path()."/res/img/widgets/UserChooser/emptyUser.png";    
    } 
    
    <img class="currentUser" src='$path'>
    exec("user-select", array("fieldName" => $fieldName));
    <input type='hidden' class='user-select-zaqfrsj6nf-{$fieldName}' name='{$fieldName}' value='{$userID}'>
</div>