<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoe_store';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post('/add_store', function() use ($app) {
        $id = null;
        $store_name = $_POST['store_name'];
        $new_store = new Store($store_name, $id);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    })

    $app->post('/delete_stores', function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post('/add_brand', function() use ($app) {
        $brand_name = $_POST['brand_name'];
        $id = null;
        $new_brand = new Brand($brand_name, $id);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post('/delete_brands', function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get('/stores/{id}', function($id) use ($app) {
        $store = Store::find($id);
        $brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('stores.html.twig', array('store' => $store, 'brands' => $brands, 'all_brands' => $all_brands));
    });

    $app->post('/add_brands', function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        $brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('stores.html.twig', array('store' => $store, 'brands' => $brands, 'all_brands' => $all_brands));
    });

    $app->get('/store/{id}', function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    $app->patch('/stores/{id}', function($id) use ($app) {
        $store = Store::find($id);
        $store->update($_POST['store_name']);
        $brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('stores.html.twig', array('store' => $store, 'brands' => $brands, 'all_brands' => $all_brands));
    });

    $app->delete('/stores/{id}', function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get('/brands/{id}', function($id) use ($app) {
        $brand = Brand::find($id);
        $stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app['twig']->render('brands.html.twig', array('brand' => $brand, 'stores' => $stores, 'all_stores' => $all_stores));
    });

    $app->post('/add_stores', function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        $stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app['twig']->render('brands.html.twig', array('brand' => $brand, 'stores' => $stores, 'all_stores' => $all_stores));
    });


    return $app;

?>
