<? 

admin::header();

<div class='w7ywyb7f5' >

    <h1>Состояние системы</h1>
    
    $event = new \Infuso\Cms\Utils\Heartbeat\Event("Infuso/Admin/Heartbeat");
    $event->fire();
    
    <table>
        foreach($event->getMessages() as $message) {        
        
            $class = "message";  
            
            if($message["type"] == \Infuso\Cms\Utils\Heartbeat\Event::TYPE_ERROR) {
                $class = "error";
            }
            
            if($message["type"] == \Infuso\Cms\Utils\Heartbeat\Event::TYPE_WARNING) {
                $class = "warning";
            }
            
            <tr class='{$class}' >        
                <td class='class' >{$message['class']}</td>
                <td class='method' >{$message[method]}</td>
                <td>
                    echo $message["message"];                    
                </td>                
            </tr>    
        }
    </table>

</div>

admin::footer();