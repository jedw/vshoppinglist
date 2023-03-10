<?php

namespace App\Models;

use CodeIgniter\Model;

class ShoppingModel extends Model
{
    protected $table = 'shopping';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'item', 'checkoff'];
}
