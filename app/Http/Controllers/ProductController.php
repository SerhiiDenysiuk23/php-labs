<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public const PRODUCTS = [
        [
            'id' => '4263ed5c-8d78-4b65-99d3-059321ca5629',
            'name' => 'product1',
            'description' => 'description1',
            'price' => '100'
        ],
        [
            'id' => '9897dc23-e6e6-47f5-bc20-daa776256ece',
            'name' => 'product2',
            'description' => 'description2',
            'price' => '200'
        ],
        [
            'id' => '3992b376-1867-4076-94e6-cd7612bb690a',
            'name' => 'product3',
            'description' => 'description3',
            'price' => '300'
        ]
    ];

    /**
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        return response()->json(self::PRODUCTS, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getProductItem(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $product], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createProduct(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!$requestData || !isset($requestData['name']) || !isset($requestData['description']) || !isset($requestData['price'])) {
            return response()->json(['data' => ['error' => 'Not enough parameters ']], Response::HTTP_BAD_REQUEST);
        }
        $productId = Str::uuid();

        $newProductData = [
            'id' => $productId,
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'price' => $requestData['price']
        ];

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $newProductData
        ], Response::HTTP_CREATED);
    }


    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProduct(string $id, Request $request): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $product['name'] = $data['name'];
        }

        if (isset($data['description'])) {
            $product['description'] = $data['description'];
        }

        if (isset($data['price'])) {
            $product['price'] = $data['price'];
        }

        return response()->json([
            'data' => $product
        ], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function deleteProduct(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $products = self::PRODUCTS;

        for ($i = 0; $i <= count($products); $i++) {
            if ($products[$i]['id'] === $id) {
                unset($products[$i]);
            }
        }
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param array $products
     * @param string $id
     * @return array|null
     */
    public function getProductItemById(array $products, string $id): ?array
    {
        foreach ($products as $product) {
            if ($product['id'] != $id) {
                continue;
            }

            return $product;
        }

        return null;
    }
}
