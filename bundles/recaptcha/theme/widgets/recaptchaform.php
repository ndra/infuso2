<?
head("<script src='https://www.google.com/recaptcha/api.js'></script>");

$publicKey =  \Infuso\ReCaptcha\ReCaptcha::publicKey();
if(!$publicKey){
    return; 
}

$helper = \Infuso\Template\Helper("<div>");

foreach($widget->style() as $key => $val) {
    $helper->style($key, $val);
}

$helper->addClass("g-recaptcha");
$helper->attr("data-sitekey", $publicKey);
$helper->begin();
$helper->end();
