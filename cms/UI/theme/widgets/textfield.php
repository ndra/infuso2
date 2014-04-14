<? 

exec("../../shared");

$containerStyles = array(
    "margin",
    "margin-left",
    "margin-right",
    "margin-top",
    "margin-bottom",
);

$container = helper("<span class='x8zq1fi07zr' >");
$container->begin();

    $value = $widget->param("value");
    $name = $widget->param("name");
    
    $input = helper("<input type='textfield' value='{$value}' name='{$name}' />");
    
    // Некоторые стили, например отступы, присваиваются контейнеру
    // Все остальные, например цвет, присваиваются полю
       
    foreach($widget->style() as $key => $val) {
        if(in_array($key, $containerStyles)) {
            $container->style($key,$val);
        } else {
            $input->style($key,$val);
        }
    }
    
    $input->exec();
    
    <div class='button' ></div>
$container->end();