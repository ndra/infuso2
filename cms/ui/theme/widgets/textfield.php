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

    $input = helper("<input type='text' />");
    $input->attr("name", $widget->param("name"));
    $input->attr("value", $widget->param("value"));
    $input->attr("placeholder", $widget->param("placeholder"));    
    
    // Некоторые стили, например отступы, присваиваются контейнеру
    // Все остальные, например цвет, присваиваются полю
       
    foreach($widget->style() as $key => $val) {
        if(in_array($key, $containerStyles)) {
            $container->style($key,$val);
        } else {
            $input->style($key,$val);
        }
    }
    
    foreach($widget->attr() as $key => $val) {
        $input->attr($key,$val);
    }
    
    $input->exec();
    
    if($widget->param("clearButton")) {
        <div class='button' ></div>
    }
    
$container->end();