<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Core implements HttpKernelInterface
{
    protected $routes;

    public function __construct()
    {
        //$this->routes = new RouteCollection();
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $attributes = $matcher->match($request->getPathInfo());
            print_r($attributes);
            $controller = $attributes['_controller'];
            // $method = $attributes['_method'];
            array_unshift($attributes, $request);
            unset($attributes['_controller']);
            // unset($attributes['_method']);
            $response = call_user_func_array([new $controller, '__construct'], $attributes);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    public function map($routes)
    {
        $this->routes = $routes;
        // print_r($routes);
        // die('here');
        // foreach ($routes as $route) {
        //     echo '<pre>';
        //     print_r($route);
        //     echo '</pre>';
        // }
        // $this->routes->add($path, new Route(
        //     $path,
        //     ['controller' => $controller]
        // ));
    }
}