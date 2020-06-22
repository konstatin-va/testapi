<?php

namespace App\Controller\Api;

use App\Service\Api;
// use App\Exceptions\NotFoundException;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProductController extends Api
{
    // public function view(int $articleId)
    // {
    //     $product = Product::getById($articleId);

    //     if ($article === null) {
    //         throw new NotFoundException();
    //     }

    //     $this->view->displayJson([
    //         'articles' => [$article]
    //     ]);
    // }

    public function index()
    {
        $res = [
            'test status' => 'success', 
            'uri' => '/api/products'
        ];

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($res);
    }

    public function pay($id)
    {
        $res = [
            'test status' => 'success', 
            'uri' => '/api/payment/' . $id
        ];

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($res);
    }
}