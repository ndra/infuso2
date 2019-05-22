<?

if($battery->cell()->exists()) {
    <h1 class='g-heading' >Батарея для электровелосипеда {$battery->serial()}s {$battery->parallel()}p {$battery->cell()->vendor()->title()} {$battery->cell()->title()} </h1>
} else {
    <h1 class='g-heading' >Калькулятор батареи электровелосипеда</h1>
}
