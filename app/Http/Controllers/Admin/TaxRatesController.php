<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\UpdateTaxRateRequest;
use App\Http\Requests\Admin\TaxRates\StoreTaxRateRequest;
use App\Models\TaxRate;
use App\Repositories\TaxRateRepository;
use Illuminate\Http\Request;

class TaxRatesController extends Controller
{
    protected $taxRateRepository;

    public function __construct(TaxRateRepository $taxRateRepository)
    {
        $this->taxRateRepository = $taxRateRepository; 
    }

    public function index()
    {
        $taxRates = $this->taxRateRepository->getAllPaginated();
        return view('admin.taxRates.index', compact('taxRates'));
    }

    public function create()
    {
        return view('admin.taxRates.create');
    }

    public function store(StoreTaxRateRequest $request)
    {
        TaxRate::create($request->all());

        return redirect()->route('taxRates.index')->with('success', __('labels.added'));
    }

    public function edit(TaxRate $taxRate)
    {

        return view('admin.taxRates.edit', compact('taxRate'));
    }

    public function update(UpdateTaxRateRequest $request, TaxRate $taxRate)
    {
        $data = $request->only($taxRate->getFillable());

        $this->taxRateRepository->update($taxRate->id, $data, 'product');
    
        return redirect()->route('products.index')->with('success', __('labels.added'));
    }

    public function destroy(TaxRate $taxRate)
    {
        $taxRate->delete();
        
        return redirect()->route('taxRates.index');
    }
}
