<?

<div class='H0zke0A3zR' >

    <h2 class='g-header' >Доска почета</h1>
    <table>
        foreach(\user::all()->withRole("heapit:manager") as $user) {
            <tr>
                <td>{$user->title()}</td>
                <td>
                    exec("/heapit/shared/user-bar", array(
                        "user" => $user,
                    ));
                </td>
            </tr>
        }
    </table>

</div>
