<?

if($battery->cell()->exists()) {
    $title = "Батарея для электровелосипеда / электроскутера
        {$battery->serial()}s {$battery->parallel()}p {$battery->cell()->vendor()->title()} {$battery->cell()->title()}";
    param("head/title", $title);    
} else {
    param("head/title", "Калькулятор батареи электровелосипеда");
}

add("center", "content");
exec("/site/layout");