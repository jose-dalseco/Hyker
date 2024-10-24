<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use CodeIgniter\RESTful\ResourceController;

class OrderController extends ResourceController
{
    protected $modelName = 'App\Models\OrderModel';
    protected $format    = 'json';

    public function index()
    {
        $orders = $this->model->findAll();
        return $this->respond($orders);
    }

    public function show($id = null)
    {
        $order = $this->model->find($id);
        if ($order) {
            $orderItemModel = new OrderItemModel();
            $order['items'] = $orderItemModel->where('order_id', $id)->findAll();
            return $this->respond($order);
        }
        return $this->failNotFound('Pedido não encontrado');
    }

    public function create()
    {
        $data = $this->request->getJSON();
        $this->db->transStart();

        $orderId = $this->model->insert($data);
        if ($orderId) {
            $orderItemModel = new OrderItemModel();
            foreach ($data->items as $item) {
                $item->order_id = $orderId;
                $orderItemModel->insert($item);
            }
            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                return $this->fail('Falha ao criar o pedido');
            }
            return $this->respondCreated(['id' => $orderId]);
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
        return $this->fail('Falha ao deletar o pedido');
    }
}
