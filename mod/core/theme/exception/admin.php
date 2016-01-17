<? 

header();
lib::reset();

<div class='ggbl9buyfa' >
    <h1>У нас проблемы!</h1>
    echo $exception->getMessage();
    
    <br/><br/>
    <b>Файл:</b> {$exception->getFile()}    
    <br/>
    <b>Строка:</b> {$exception->getLine()} 
    
    <br/><br/>
    <pre>
        echo $exception->getTraceAsString();
    </pre>
    
</div>

footer();