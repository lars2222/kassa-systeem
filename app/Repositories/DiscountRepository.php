<?php

namespace App\Repositories;

use App\Models\Discount;

class DiscountRepository extends Repository
{
    public function __construct(Discount $model) 
    {
        $this->model = $model; 
    }
}