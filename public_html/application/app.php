<?php

use App\Container;
use App\ContainerValueResolver;
use App\ExceptionListener;
use App\repositories\ProductRepository;
use App\repositories\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$routes = require __DIR__ . '/config/routes/api.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..'); // шлях до .env
$dotenv->load();

require __DIR__ . '/db.php';

$container = new Container();
$container->set(
    ProductRepositoryInterface::class,
    fn($c) => new ProductRepository(new \App\modules\products\models\Products())
);

$matcher = new UrlMatcher($routes, new RequestContext());
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));
$dispatcher->addSubscriber(new ExceptionListener());

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver(new ArgumentMetadataFactory(), [
    new ContainerValueResolver($container),
    new RequestValueResolver(),
    new SessionValueResolver(),
    new DefaultValueResolver(),
    new VariadicValueResolver(),
]);

$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);



