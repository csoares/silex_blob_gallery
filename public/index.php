<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

require __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();

// connect to mysql atabase
$dsn = 'mysql:dbname=pictureExample;host=127.0.0.1;charset=utf8';
try {
    $dbh = new PDO($dsn, 'root', 'root');
} catch (PDOException $e) {
    die('Connection failed: ');
}

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app->get( '/', function() use ( $app ) {
    return $app['twig']->render('layout.html.twig');
});


$app->get('/upload', function() use ( $app ) {
    return $app['twig']->render('upload_form.html.twig');
})
->bind('upload_form');

$app->post('/send', function( Request $request ) use ( $app, $dbh ) {
    $file_bag = $request->files;
    $image = $file_bag->get('image');
    if ( !empty($image) && $image->isValid() )
    {
        $data = file_get_contents($image);
    
        $sql="INSERT INTO ae_gallery SET data=?";
        $sth=$dbh->prepare($sql);
        $sth->execute(array($data));
    
    }    
    
    return new RedirectResponse($app['url_generator']->generate('gallery'));
})
->bind('upload_post');

$app->get('/view', function() use ( $app , $dbh) {
    $sql="SELECT TO_BASE64(data) as data FROM ae_gallery";
    $sth=$dbh->prepare($sql);
    $sth->execute();
    $images=$sth->fetchAll(PDO::FETCH_ASSOC);
    
   
    return $app['twig']->render('gallery.html.twig',array(
        'images' => $images,
    ));
})
->bind('gallery');

$app['debug'] = true; 
$app->run();