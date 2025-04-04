<?php
namespace App\modules\products\controllers;


use App\modules\products\requests\CreateRequest;
use App\repositories\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends \Illuminate\Routing\Controller
{

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param string $id
     * @return Response
     */
    public function findOne(ProductRepositoryInterface $productRepository, string $id): Response
    {
       return new JsonResponse($productRepository->find($id), Response::HTTP_OK);
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @return Response
     */
    public function findAll(ProductRepositoryInterface $productRepository): Response
    {
        return new JsonResponse($productRepository->all(), Response::HTTP_OK);
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(ProductRepositoryInterface $productRepository, Request $request): Response
    {
        $data = (new CreateRequest($request))->validate();

        $product = $productRepository->create([
            'uuid' => $data['uuid'],
            'name' => $data['name'],
            'price' => $data['price'],
            'category' => $data['category'],
        ]);
        return new JsonResponse(collect([
            'status' => 'Created successfully',
            'data' => $product,
        ]), Response::HTTP_OK);
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Request $request
     * @param string $id
     * @return Response
     * @throws \Exception
     */
    public function update(ProductRepositoryInterface $productRepository, Request $request, string $id): Response
    {
        $data = (new CreateRequest($request))->validate();

        $product = $productRepository->update($id, [
            'name' => $data['name'],
            'price' => $data['price'],
            'category' => $data['category'],
        ]);

        return new JsonResponse(collect([
            'status' => 'Updated successfully',
            'data' => $product,
        ]), Response::HTTP_OK);
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param string $id
     * @return Response
     */
    public function delete(ProductRepositoryInterface $productRepository, string $id): Response
    {
        if ($productRepository->delete($id)) {
            return new JsonResponse(collect(['status' => 'Deleted successfully']), Response::HTTP_OK);
        }
        return new JsonResponse(collect(['status' => 'Delete failed']), Response::HTTP_OK);
    }
}