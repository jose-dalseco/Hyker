<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    public function index()
    {
        $products = $this->model->findAll();
        return $this->respond($products);
    }

    public function show($id = null)
    {
        $product = $this->model->find($id);
        if ($product) {
            return $this->respond($product);
        }
        return $this->failNotFound('Produto não encontrado');
    }

    public function create()
    {
        $data = $this->request->getJSON();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->fail($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if ($this->model->update($id, $data)) {
            return $this->respond($data);
        }
        return $this->fail($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->fail('Falha ao deletar o produto');
    }
}
