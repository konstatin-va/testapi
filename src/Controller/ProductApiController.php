<?php

namespace App\Controller;

use App\Entity\Product;
use App\Api\AbstractApi;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Faker\Generator;

class ProductApiController extends AbstractApi
{
    protected $apiName = 'product';
    private $entityManager;

    public function __construct(Request $request, EntityManager $entityManager)
    {
        parent::__construct($request);
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        $data = $this->entityManager->getRepository(Product::class)->findProducts($this->entityManager);

        return [
            'status' => 'success',
            'code' => 200,
            'response' => [
                'products' => $data,
                'Location' => '/' . $this->apiName
            ]
        ];
    }

    /**
     * Создаем 20 рандомных товаров - id, name, price
     */
    public function create()
    {
        $productIds = [];
        $productLinks = [];

        $faker = Factory::create();

        for ($i = 0; $i <= 20; $i++) {

            $product = new Product();

            $product->setName(rtrim($faker->text(15), '.'));
            $product->setCost($faker->randomFloat(2, 1, 9999));

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $productIds[] = $product->getId();
            $productLinks[] = '/' . $this->apiName . '/' . $product->getId();
        }

        return [
            'status' => 'success',
            'code' => 201,
            'response' => [
                'product' => [
                    'id' => $productIds
                ],
                'link' => [
                    'Location' => $productLinks
                ]
            ]
        ];
    }
}
