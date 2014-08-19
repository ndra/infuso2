<?

<a href='/cart' >

    echo "Корзина";
    
    $cart = \Infuso\Eshop\Model\Cart::active();
    echo $cart->items()->count();
    
    <span> {$cart->total()} р.</span>

</a>