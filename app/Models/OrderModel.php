<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'total_amount', 'status', 'shipping_address', 'shipping_phone'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'user_id'          => 'required|integer',
        'total_amount'     => 'required|numeric',
        'status'           => 'required|in_list[pending,processing,completed,cancelled]',
        'shipping_address' => 'required|max_length[255]',
        'shipping_phone'   => 'required|max_length[20]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
