<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\RESTful\ResourceController;

class CategoryController extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    public function index()
    {
        $categories = $this->model->findAll();
        return $this->respond($categories);
    }

    public function show($id = null)
    {
        $category = $this->model->find($id);
        if ($category) {
            return $this->respond($category);
        }
        return $this->failNotFound('Categoria não encontrada');
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
        return $this->fail('Falha ao deletar a categoria');
    }
}
