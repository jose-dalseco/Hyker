<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'product_id', 'quantity', 'price'];

    // Validation
    protected $validationRules      = [
        'order_id'   => 'required|integer',
        'product_id' => 'required|integer',
        'quantity'   => 'required|integer|greater_than[0]',
        'price'      => 'required|numeric'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
