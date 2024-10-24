<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use CodeIgniter\RESTful\ResourceController;

class ReviewController extends ResourceController
{
    protected $modelName = 'App\Models\ReviewModel';
    protected $format    = 'json';

    public function index()
    {
        $reviews = $this->model->findAll();
        return $this->respond($reviews);
    }

    public function show($id = null)
    {
        $review = $this->model->find($id);
        if ($review) {
            return $this->respond($review);
        }
        return $this->failNotFound('Avaliação não encontrada');
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
        return $this->fail('Falha ao deletar a avaliação');
    }
}
