<? 

header();

lib::reset();

<div class='jUJZyDrMqf' >

    <table>
        <tr>
            <td style='width:300px;' >
                <div class='left' >
                    exec("user-list");
                </div>
            </td>
            <td>
                foreach(user::all()->withRole("boardUser") as $user) {
            		exec("user", [
            		    "user" => $user,
            		]);
                }
            </td>
        </tr>
    </table>
   
</div>

footer();