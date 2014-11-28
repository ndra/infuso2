<?

<div class='dg13nhbck2' >

    <h2>{$user->title()}</h2>
    
    <table> 
        <tr>
            <td>
                <div style='width:400px;' >
                    widget("infuso\\board\\widget\\timeline")
                        ->param("from", \util::now()->date()->shiftMonth(-1))
                        ->param("to", \util::now()->date())
                        ->userId($user->id())
                        ->exec();
                </div>
            </td>
            <td>
                exec("projects");
            </td>
        </tr>
    </table>
    
</div>