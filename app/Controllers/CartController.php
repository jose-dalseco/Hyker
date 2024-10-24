<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class CartController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $cart = $this->session->get('cart') ?? [];
        return $this->response->setJSON($cart);
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado']);
        }

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }

        $this->session->set('cart', $cart);

        return $this->response->setJSON(['message' => 'Produto adicionado ao carrinho', 'cart' => $cart]);
    }

    public function remove()
    {
        $productId = $this->request->getPost('product_id');

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set('cart', $cart);
            return $this->response->setJSON(['message' => 'Produto removido do carrinho', 'cart' => $cart]);
        }

        return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado no carrinho']);
    }

    public function update()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            $this->session->set('cart', $cart);
            return $this->response->setJSON(['message' => 'Carrinho atualizado', 'cart' => $cart]);
        }

        return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado no carrinho']);
    }
}
