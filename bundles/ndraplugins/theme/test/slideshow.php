<?

header();

<div class='kTuQhs2o7h' >
    for($i = 0; $i < 15; $i ++) {
        
        $src = $this->bundle()->path()."/res/test/test1.jpg";
        $preview = \Infuso\Core\File::get($src)
            ->preview(100,100)
            ->crop();
        <a class='slideshow' href='{$src}' >
            <img src='{$preview}' />
        </a>
        
        $src = $this->bundle()->path()."/res/test/test2.jpg";
        $preview = \Infuso\Core\File::get($src)
            ->preview(100,100)
            ->crop();
        <a class='slideshow' href='{$src}' >
            <img src='{$preview}' />
        </a>
        
    }
</div>

\NDRA\Plugins\Slideshow::create()->bind(".slideshow");

footer();