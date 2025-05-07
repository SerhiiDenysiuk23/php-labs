<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public const PRODUCTS = [
        [
            'id' => '221d84d9-c793-4db0-bcbb-9f38d26602e4',
            'name' => 'product1',
            'description' => 'description1',
            'price' => '100'
        ],
        [
            'id' => 'b089cc6e-19d9-4964-b786-f427c3dfee86',
            'name' => 'product2',
            'description' => 'description2',
            'price' => '150'
        ],
        [
            'id' => '8a24212e-d3c7-4aa3-961b-c6271c4c0ec5',
            'name' => 'product3',
            'description' => 'description3',
            'price' => '300'
        ]
    ];

    /**
     * @return JsonResponse
     */
    #[Route('/products', name: 'get_products', methods: [Request::METHOD_GET])]
    public function getProducts(): JsonResponse
    {
        return new JsonResponse(['data' => self::PRODUCTS], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'get_product_item', methods: [Request::METHOD_GET])]
    public function getProductItem(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $product], Response::HTTP_OK);
    }

    #[Route('/products', name: 'post_products', methods: [Request::METHOD_POST])]
    public function createProduct(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $productId = random_int(1, 100);

        $newProductData = [
            'id' => $productId,
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'price' => $requestData['price']
        ];

        // TODO insert to db

        return new JsonResponse([
            'data' => $newProductData
        ], Response::HTTP_CREATED);
    }

    #[Route('/products/{id}', name: 'patch_products', methods: [Request::METHOD_PATCH])]
    public function updateProduct(string $id, Request $request): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $product['name'] = $requestData['name'];
        $product['description'] = $requestData['description'];
        $product['price'] = $requestData['price'];

        // TODO insert to db

        return new JsonResponse([
            'data' => $product
        ], Response::HTTP_OK);
    }

    #[Route('/products/{id}', name: 'delete_products', methods: [Request::METHOD_DELETE])]
    public function deleteProduct(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        // TODO remove from db

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param array $products
     * @param string $id
     * @return array|null
     */
    public function getProductItemById(array $products, string $id): ?array
    {
        $filtered = array_filter($products, fn($product) => $product['id'] === $id);
        return $filtered ? reset($filtered) : null;
    }
}
