<?php

namespace App\Api;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApi
{
    protected $apiName = '';
    protected $method = '';
    protected $requestUri = '';
    protected $requestParams = '';
    protected $action = '';

    public function __construct(Request $request)
    {
        $this->requestUri = explode('/', trim($request->server->get('REQUEST_URI'), '/'));
        $this->requestParams = $_REQUEST;

        $this->method = $request->server->get('REQUEST_METHOD');
    }

    public function processRequest()
    {
        $this->action = $this->getAction();

        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                return 'index';
                break;
            case 'POST':
                return 'create';
                break;
            case 'PATCH':
                return 'pay';
                break;
            default:
                return null;
        }
    }

    abstract protected function index();
}
