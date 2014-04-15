<? 

$user = new user();
$field = mod::field("array");
$field->setModel($user);
$view = new \Infuso\Cms\Reflex\FieldView\numberView($field);
$view->template()->exec();

