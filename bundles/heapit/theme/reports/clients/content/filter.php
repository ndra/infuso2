<? 

<div class='bv3vjfvd5n' >
    
    $years = array(2001,2002,2014);
    
    foreach($years as $year) {
        $id = \util::id();
        <input type='checkbox' id='{$id}' />
        <label for='{$id}' >{$year}</label>
    }
    
    <span style='margin-right: 40px' ></span>

    $id = \util::id();
    <input type='checkbox' id='{$id}' />
    <label for='{$id}' >Доход</label>    

    $id = \util::id();
    <input type='checkbox' id='{$id}' />
    <label for='{$id}' >Расход</label>
    
</div>