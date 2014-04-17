<?
tmp::jq();
\Infuso\Template\Lib::jqui(); 

exec("../../shared");

$containerStyles = array(
    "margin",
    "margin-left",
    "margin-right",
    "margin-top",
    "margin-bottom",
);

$container = helper("<span class='autocomplete-jk7zsaj00t' >");
$container->begin();

    $value = $widget->param("value");
    $name = $widget->param("name");
    $title = $widget->param("title");
    $cmd = $widget->param("cmd");
    $cmdParams = $widget->param("cmdParams");
    
    $input = helper("<input type='text' />");
    $input->attr("value", $title);
    $input->attr("widget:cmd", $cmd);
    $input->attr("widget:cmdparams", $cmdParams);
    $input->attr("placeholder", $widget->param("placeholder"));

    $hiddenInput = helper("<input type='hidden' value='{$value}' name='{$name}'/>");
    
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
    $hiddenInput->exec();
    <div class='button' ></div>
    //<div class='button' >
$container->end();