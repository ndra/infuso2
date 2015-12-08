<?

<div class='nqalth29om' >

    $info = \user::active()->data();
    //echo "<img src='/admin/res/user.gif' align='absmiddle' style='margin-right:5px;' />";
    echo $info ? "<a class='logout'>".$info["email"]."</a>" : "Вход не выполнен";
    echo " ";
    if(\Infuso\Core\Superadmin::check()) {
        echo ", root";
    }    

</div>