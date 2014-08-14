<?

header();

<form class='e73i7MYyZT' >
    <input name='field-1' />
    <div class='error-field-1' style='border:1px solid red;display:none;' ></div>
    <input name='field-2' />
    <div class='error-field-2' ></div>
    <input type='submit' />
</form>

(new \Infuso\Form\TestForm())->builder()->bind(".e73i7MYyZT");

footer();