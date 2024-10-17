<?php

namespace App\Repositories;

use App\Models\TaxRate;

class TaxRateRepository extends Repository
{
    public function __construct(TaxRate $model) 
    {
        $this->model = $model; 
    }
}