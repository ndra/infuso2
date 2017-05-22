<?

admin::header();

<div class='mpByV9HkzA' >
    
    $reflector = new \ReflectionClass($class);
    
    $modifiers = implode(' ', \Reflection::getModifierNames($reflector->getModifiers()));        
    <h1>{$modifiers} class {$class}</h1>
    
    // Сортируем методы по алфавиту
    $methods = $reflector->getMethods();
    usort($methods, function($a, $b) {
        return strcmp($a->getName(), $b->getName());
    });
    
    <div class='methods-menu' >
        foreach($methods as $method) {
            <div>{$class}::{$method->getName()}</div>
        }
    </div>
    
    foreach($methods as $method) {
        <div class='method' >
        
            // Модификаторы
            $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));        
            
            // Имя метода и аргументы
            $args = array_map(function($param) {
                return "$".$param->getName();
            }, $method->getParameters());
            $args = implode(", ", $args);
            <h2><span class='modifiers' >{$modifiers}</span> {$method->getName()}({$args})</h2>
            
            
            $comment = $method->getDocComment();
            $comment = preg_replace("/^\/\*\*/", "", $comment);
            $comment = preg_replace("/\*\*\/$/", "", $comment);
            $comment = preg_replace("/^\s*\*\s*/m", "", $comment);
            $comment = nl2br($comment);
            <div class='comments' >{$comment}</div>
        </div>
    }
</div>

admin::footer();