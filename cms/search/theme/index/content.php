<?

<div class='ocM6ZVP175' >
    
    <form>
        <input name='query' value='{e($query)}' />
        <input value='Найти' type='submit' value='Найти' />
    </form>
    
    <div class='results' >
        foreach($results as $result) {
            <div class='result' >
                $result->snippet()->exec();
            </div>
        }
    </div>
    
</div>