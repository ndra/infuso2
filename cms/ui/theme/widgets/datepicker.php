<? 

\Infuso\Template\Lib::jqui(); 
$date = "";
$value = $widget->param("value");
if($value) {
    $date = \util::date($value)->date()->num();
}

$placeholder = "Указать дату";
if($widget->param("placeholder")){
    $placeholder = $widget->param("placeholder");   
}

$name = $widget->param("name");

exec("../../shared");

$containerStyles = array(
    "margin",
    "margin-left",
    "margin-right",
    "margin-top",
    "margin-bottom",
);

$container = helper("<span class='datepicker-89z0fcfy09' >");
$container->begin();
    $input = helper("<input type='text' />");
    $input->attr("value", $date);
    $input->attr("placeholder", $placeholder);
    $input->attr("readonly", "readonly"); 
    $input->style("width",70);
    $hiddenInput = helper("<input type='hidden' value='{$value}' name='{$name}'/>");
    $input->exec();
    $hiddenInput->exec();     
$container->end();