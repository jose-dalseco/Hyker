<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id', 'name', 'description', 'price', 'image', 'stock'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'category_id' => 'required|integer',
        'name'        => 'required|min_length[3]|max_length[200]',
        'description' => 'permit_empty|max_length[1000]',
        'price'       => 'required|numeric',
        'image'       => 'permit_empty|max_length[255]',
        'stock'       => 'required|integer'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
