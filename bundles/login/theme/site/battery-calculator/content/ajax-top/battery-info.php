<?

if(!$battery->isError()) {

    exec("/site/layout/shared");
    
    <div class='TYx6KRzGA1' >
    
        <div class='top' >
            <div>
                exec("main");
            </div>
            <div>
                exec("photo");
            </div>
            <div>
               // exec("photo");
                exec("additional");
            </div>
        </div>
        
        exec("price");

    </div>
    

} else {
    
    echo $battery->errorText();
    
}