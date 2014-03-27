<? 

mod::coreJS();

admin::header();

$bundlePath = $this->bundle()->path();
tmp::js($bundlePath."/res/js/window.js");

<table class='x0h4tfwmhnn' >
    <tr>
        <td style='width:200px;' >
            tmp::region("left");
        </td>
        <td style='width:4px;border-left:1px solid #ededed;border-right:1px solid #ededed;' ></td>
        <td>
            tmp::region("center");
        </td>
    </tr>
</table>

admin::footer();