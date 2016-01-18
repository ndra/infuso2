<?

header();

$video = new \NDRA\Plugins\Video("http://www.youtube.com/watch?v=QrU1hZxSEXQ");
echo $video->player(300,200);

footer();

