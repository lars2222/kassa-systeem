<?php

namespace App\Repositories;

use App\Models\Inventory;

class InventoryRepository extends Repository
{
    public function __construct(Inventory $model) 
    {
        $this->model = $model; 
    }
}