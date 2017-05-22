<?

admin::header();

$cleanDoc = function($comment) {
    $comment = preg_replace("/^\/\*\*/", "", $comment);
    $comment = preg_replace("/\*\*\/$/", "", $comment);
    $comment = preg_replace("/^\s*\*\s*/m", "", $comment);
    $comment = trim($comment);
    $comment = nl2br($comment);
    return $comment;
};

<div class='mpByV9HkzA' >
    
    $reflector = new \ReflectionClass($class);
    
    $modifiers = implode(' ', \Reflection::getModifierNames($reflector->getModifiers()));        
    <h1>
        echo "{$modifiers} class {$class}";
        $parent = $reflector->getParentClass();
        if($parent) {
            echo " extends ";
            $url = action("infuso\\cms\\bundlemanager\\controller\\doc", "class")."?class=".urlencode($parent->getName());
            <a href='{$url}' >{$parent->getName()}</a>
        }
    </h1>
    
    $comment = $cleanDoc($reflector->getDocComment());
    if($comment) {
        <div class='class-comment' >{$comment}</div>
    }
    
    // Сортируем методы по алфавиту
    $methods = $reflector->getMethods();
    usort($methods, function($a, $b) use ($reflector) {
        
        $n1 = $a->getDeclaringClass()->getName() == $reflector->getName();
        $n2 = $b->getDeclaringClass()->getName() == $reflector->getName();
        if($n1 && !$n2) {
            return -1;
        }
        if($n2 && !$n1) {
            return 1;
        }
        
        
        return strcmp($a->getName(), $b->getName());
    });
    
    <div class='methods-menu' >
        <h2>Собственные методы</h2>
        foreach($methods as $method) {
            $definedHere = $method->getDeclaringClass()->getName() == $reflector->getName();
            if($definedHere) {
                <div><a href='#{$method->getName()}' >{$class}::{$method->getName()}</a></div>
            }
        }
        <h2>Наследуемые методы</h2>
        foreach($methods as $method) {
            $definedHere = $method->getDeclaringClass()->getName() == $reflector->getName();
            if(!$definedHere) {
                <div><a href='#{$method->getName()}' >{$class}::{$method->getName()}</a></div>
            }
        }
    </div>
    
    foreach($methods as $method) {
        <div class='method' >
        
            <a name='{$method->getName()}' ></a>
        
            // Модификаторы
            $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));        
            
            // Имя метода и аргументы
            $args = array_map(function($param) {
                return "$".$param->getName();
            }, $method->getParameters());
            $args = implode(", ", $args);
            <h2><span class='modifiers' >{$modifiers}</span> {$method->getName()}({$args})</h2>
            
            
            $comment = $cleanDoc($method->getDocComment());
            <div class='comments' >{$comment}</div>
        </div>
    }
</div>

admin::footer();