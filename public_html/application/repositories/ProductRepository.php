<?php
namespace App\repositories;

use App\modules\products\models\Products;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Products $product)
    {
        $this->model = $product;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->model->findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->model->findOrFail($id);
        return $product->delete();
    }
}