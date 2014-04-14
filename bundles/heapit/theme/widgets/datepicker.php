<? 

\Infuso\Template\Lib::jqui(); 
$date = "";
if($value) {
    $date = \util::date($value)->date()->num();
}  
<input class='yoo8c3of0o' type='text' placeholder="Указать дату" value='{$date}' readonly="readonly" >
<input type='hidden' name='{$fieldName}' value='{$value}'>