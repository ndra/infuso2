<? 

$file = $view->field()->value();
$preview = \file::get($file)->preview(150,150);

<img src='{$preview}' />