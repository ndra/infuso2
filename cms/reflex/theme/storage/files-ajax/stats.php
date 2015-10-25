<?

// Подвал со статистикой    
<div class='qndPtIp81f bottom' >
    echo \Infuso\Util\Units::formatBytes($storage->size());
    echo " в ".$storage->count()." файлов";    
</div>