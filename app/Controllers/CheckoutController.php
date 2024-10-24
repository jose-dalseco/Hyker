<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class CheckoutController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $cart = $this->session->get('cart') ?? [];

        if (empty($cart)) {
            return $this->response->setJSON(['error' => 'Carrinho vazio']);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $this->response->setJSON([
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function process()
    {
        $cart = $this->session->get('cart') ?? [];

        if (empty($cart)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Carrinho vazio']);
        }

        $userId = $this->request->getPost('user_id'); // Assumindo que o usuário está autenticado
        $shippingAddress = $this->request->getPost('shipping_address');
        $shippingPhone = $this->request->getPost('shipping_phone');

        if (!$userId || !$shippingAddress || !$shippingPhone) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Informações de envio incompletas']);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $db = \Config\Database::connect();
        $db->transStart();

        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'shipping_phone' => $shippingPhone
        ]);

        foreach ($cart as $item) {
            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Falha ao processar o pedido']);
        }

        // Limpar o carrinho após o checkout bem-sucedido
        $this->session->remove('cart');

        return $this->response->setJSON([
            'message' => 'Pedido processado com sucesso',
            'order_id' => $orderId
        ]);
    }
}
