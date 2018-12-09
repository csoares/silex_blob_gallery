<?php
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'dbname' => 'pictureExample',
        'user' => 'root',
        'password' => '12345678',
        'charset' => 'utf8',
    ),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('layout.html.twig');
});

$app->get('/upload', function () use ($app) {
    return $app['twig']->render('upload_form.html.twig');
})->bind('upload_form');

$app->post('/send', function (Request $request) use ($app) {
    $file_bag = $request->files;
    $image = $file_bag->get('image');
    if (!empty($image) && $image->isValid()) {
        $data = file_get_contents($image);
        $app['db']->insert('ae_gallery', array('data'=>$data));
    }

    return new RedirectResponse($app['url_generator']->generate('gallery'));
})->bind('upload_post');

$app->get('/view', function () use ($app) {
    $sql = "SELECT TO_BASE64(data) as data, id, image_time FROM ae_gallery";
    $images = $app['db']->fetchAll($sql, array());

    return $app['twig']->render('gallery.html.twig', array('images' => $images));
})->bind('gallery');

$app['debug'] = true;
$app->run();
