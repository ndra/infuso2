<?

echo "Корзина";

$cart = \Infuso\Eshop\Model\Cart::active();
echo $cart->items()->count();