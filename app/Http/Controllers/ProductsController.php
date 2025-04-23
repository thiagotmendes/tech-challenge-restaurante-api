<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Services\Product\DeleteProductService;
use App\Services\Product\FindProductByCategory;
use App\Services\Product\ListProductsService;
use App\Services\Product\RegisterProductService;
use App\Services\Product\ShowProductService;
use App\Services\Product\UpdateProductService;

class ProductsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Produtos"},
     *     summary="Listar todos os produtos",
     *     description="Retorna uma lista de todos os produtos cadastrados no sistema.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Produto A"),
     *                 @OA\Property(property="description", type="string", example="Descrição do produto A."),
     *                 @OA\Property(property="price", type="number", format="float", example=29.99),
     *                 @OA\Property(property="discount", type="number", format="float", example=5.00),
     *                 @OA\Property(property="stockQuantity", type="integer", example=100),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="category", type="integer", nullable=true, example=2)
     *             )
     *         )
     *     )
     * )
     */
    public function index(ListProductsService $service): \Illuminate\Http\JsonResponse
    {
        return response()->json($service->handle());
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Produtos"},
     *     summary="Cadastrar um novo produto",
     *     description="Cria um novo produto no sistema com as informações fornecidas.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "description", "stockQuantity"},
     *             @OA\Property(property="name", type="string", example="Produto A"),
     *             @OA\Property(property="price", type="number", format="float", example=29.99),
     *             @OA\Property(property="description", type="string", example="Descrição detalhada do produto A."),
     *             @OA\Property(property="discount", type="number", format="float", example=5.00),
     *             @OA\Property(property="image", type="string", format="url", example="https://meusite.com/imagem.jpg"),
     *             @OA\Property(property="stockQuantity", type="integer", example=100),
     *             @OA\Property(property="active", type="boolean", example=true),
     *             @OA\Property(property="category", type="integer", nullable=true, example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto cadastrado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product added successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação: dados inválidos ou produto já cadastrado."
     *     )
     * )
     */
    public function store(StoreProductRequest $request, RegisterProductService $service)
    {
        $service->handle($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully'
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     tags={"Produtos"},
     *     summary="Atualizar um produto existente",
     *     description="Atualiza os dados de um produto existente no sistema com base no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto a ser atualizado",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         description="Dados do produto a ser atualizado",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "price", "description", "stock"},
     *             @OA\Property(property="name", type="string", example="Produto B"),
     *             @OA\Property(property="price", type="number", format="float", example=49.99),
     *             @OA\Property(property="description", type="string", example="Descrição do produto atualizado."),
     *             @OA\Property(property="stock", type="integer", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(
     *                 property="product",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Produto B"),
     *                 @OA\Property(property="price", type="number", format="float", example=49.99),
     *                 @OA\Property(property="description", type="string", example="Descrição detalhada do produto atualizado."),
     *                 @OA\Property(property="stock", type="integer", example=50)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação: dados inválidos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 additionalProperties={
     *                     @OA\Property(type="array", @OA\Items(type="string"))
     *                 },
     *                 example={
     *                     "name": {"O campo nome é obrigatório."},
     *                     "price": {"O preço deve ser um número positivo."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function update(StoreProductRequest $request, $id, updateProductService $service)
    {
        $product = $service->handle($request->validated(), $id);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Remover um produto",
     *     tags={"Produtos"},
     *     description="Remove permanentemente um produto do sistema pelo seu ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto a ser removido",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto removido com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Produto removido com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado."
     *     )
     * )
     */
    public function destroy($id, DeleteProductService $service): \Illuminate\Http\JsonResponse
    {
        $service->handle($id);

        return response()->json([
            'success' => true,
            'message' => 'Produto removido com sucesso.'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Buscar produto por ID",
     *     tags={"Produtos"},
     *     description="Retorna os dados de um produto específico pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do produto retornado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Produto A"),
     *             @OA\Property(property="description", type="string", example="Descrição do produto"),
     *             @OA\Property(property="image", type="string", example="https://meusite.com/imagem.jpg"),
     *             @OA\Property(property="price", type="number", format="float", example=29.90),
     *             @OA\Property(property="discount", type="number", format="float", example=5.00),
     *             @OA\Property(property="active", type="boolean", example=true),
     *             @OA\Property(property="stockQuantity", type="integer", example=100),
     *             @OA\Property(property="categoryId", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado."
     *     )
     * )
     */
    public function show($id, ShowProductService $service)
    {
        return response()->json($service->handle($id));
    }

    /**
     * @OA\Get(
     *     path="/api/products/category/{categoryId}",
     *     summary="Listar produtos por categoria",
     *     tags={"Produtos"},
     *     description="Retorna todos os produtos associados a uma determinada categoria.",
     *     @OA\Parameter(
     *         name="categoryId",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos encontrada com sucesso.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Produto A"),
     *                 @OA\Property(property="description", type="string", example="Descrição do produto"),
     *                 @OA\Property(property="image", type="string", example="https://meusite.com/imagem.jpg"),
     *                 @OA\Property(property="price", type="number", format="float", example=29.90),
     *                 @OA\Property(property="discount", type="number", format="float", example=5.00),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="stockQuantity", type="integer", example=100),
     *                 @OA\Property(property="categoryId", type="integer", example=2)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhum produto encontrado para a categoria informada.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Nenhum produto encontrado.")
     *         )
     *     )
     * )
     */
    public function findByCategory($categoryId, FindProductByCategory $service): \Illuminate\Http\JsonResponse
    {
        $result = $service->handle($categoryId);

        if (isset($result['success']) && $result['success'] === false) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }
}
