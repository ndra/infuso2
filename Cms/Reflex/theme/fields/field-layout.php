<? 

switch($view->labelALign()) {

    default:
        <table class='gpudbjvgc1' >
            <tr>
                <td class='label' >
                    echo $label;
                </td>
                <td class='content' >
                    $view->template()->exec();
                </td>
            </tr>
        </table>
        break;
        
    case $view::LABEL_ALIGN_CHECKBOX:
        <div class='gpudbjvgc1-checkbox' >
            $view->template()->exec();
        </div>
        break;        

}