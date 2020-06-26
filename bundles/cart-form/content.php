<?

<div class='x2eDLtE4nnj' >

    $form = new \Infuso\Eshop\Form\Cart();
    $form->scenario("submit");
    
    $builder = $form->builder();
    $builder->append("<input type='hidden' name='cmd' value='infuso/eshop/controller/cart/submit' />");
    $builder->exec();

</div>