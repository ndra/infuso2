<?

<a href='/cart' >

    echo "Корзина ";
    
    $cart = \Infuso\Eshop\Model\Cart::active();
    echo $cart->items()->count();
    echo " шт.";
    
    <span> {$cart->total()} р.</span>

</a>