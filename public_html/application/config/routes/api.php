<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use App\modules\products\controllers\ProductsController;
$routes = new RouteCollection();
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| Because these are all assigned the "api" middleware group, traditional auth does not apply.
| For the same endpoints to work off of web auth, add similar endpoints to the web routes configuration file.
*/

$route = new Route('/products/{id}', [
    '_controller' => [ProductsController::class, 'findOne'],
], [], [], '', [], ['GET']);
$routes->add('find_one_product', $route);

$route = new Route('/products', [
    '_controller' => [ProductsController::class, 'findAll'],
], [], [], '', [], ['GET']);
$routes->add('find_all_product', $route);

$route = new Route('/products', [
    '_controller' => [ProductsController::class, 'create']
], [], [], '', [], ['POST']);
$routes->add('create_product', $route);

$route = new Route('/products/{id}', [
    '_controller' => [ProductsController::class, 'update']
], [], [], '', [], ['PATCH']);
$routes->add('update_product', $route);

$route = new Route('/products/{id}', [
    '_controller' => [ProductsController::class, 'delete']
], [], [], '', [], ['DELETE']);
$routes->add('delete_product', $route);

return $routes;