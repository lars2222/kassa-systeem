<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discounts\StoreDiscountRequest;
use App\Http\Requests\Admin\Discounts\UpdateDiscountRequest;
use App\Models\Discount;
use App\Repositories\DiscountRepository;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected $discountRepository;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;  
    }

    public function index()
    {
        Discount::where('end_date', '<', now())->delete();


        $discounts = $this->discountRepository->getAllPaginated();
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(StoreDiscountRequest $request)
    {
        Discount::create($request->all());

        return redirect()->route('discounts.index')->with('success', __('labels.added'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $update = $request->only($discount->getFillable());

        $this->discountRepository->update($discount->id, $update, 'discount');

        return redirect()->route('discounts.index')->with('success', __('labels.added'));
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index');
    }
}
