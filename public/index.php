<?php

// use App\System\Db;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$configDirectories = __DIR__.'/../config';

$conn = require_once $configDirectories . '/db.php';

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();
$response = new Response();

$response->headers->set('Acess-Control-Allow-Origin', '*');
$response->headers->set('Acess-Control-Allow-Methods', 'GET,POST,PATCH');
$response->headers->set('Content-Type', 'application/json');

try { 
    try {
        $fileLocator = new FileLocator([$configDirectories]);
        $loader = new PhpFileLoader($fileLocator);
        $routes = $loader->load('routes.php');

        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $matcher = new UrlMatcher($routes, $context);
        $parameters = $matcher->match($request->getPathInfo());

        list($controller) = $parameters['_controller'];
        unset($parameters['_controller']);

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../Entity"), true, null, null, false);
        $entityManager = EntityManager::create($conn, $config);

        $api = new $controller($request, $entityManager, $parameters);
        $result = $api->processRequest();

        if ('success' == $result['status']) {
            $response->setContent(json_encode($result['response']));
            $response->setStatusCode($result['code']);
        } else {
            $response->setContent($result['errorInfo']['description']);
            $response->setStatusCode($result['errorInfo']['code']);
        }
    }
    catch (MethodNotAllowedException $e)
    {
        $response->setContent('Method Not Allowed');
        $response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
catch (ResourceNotFoundException $e)
{
    $response->setContent('Not Found');
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
}

$response->send();
