<? 

header();

lib::reset();

<div style='padding:20px;' >
    
    foreach(user::all()->like("roles","boardUser") as $user) {
		app()->tm("user")->param("user", $user)->exec();
    }

</div>

footer();