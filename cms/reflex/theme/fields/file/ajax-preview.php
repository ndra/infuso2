<? 

$file = $view->field()->value();
$preview = File::get($file)->preview(150,150);

<img src='{$preview}' />