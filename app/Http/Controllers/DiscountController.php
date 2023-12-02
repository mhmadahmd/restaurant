<?php

namespace App\Http\Controllers;

use App\Actions\CalculateDiscount;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Discount/Index', [
            'menus' => Menu::where('admin_rest_id', Auth::user()->id)->with(['discount'])->get()->transform(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'amount' => optional($item->discount)->amount
                ];
            })
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(request()->input('type') == 'menu') {
            return Inertia::render('Discount/Show', [
                        'parent' => Menu::find($id),
                        'children' => CalculateDiscount::run($id, request()->input('type')),
                        'type' => 'category'
                    ]);
        } else {
            return Inertia::render('Discount/Show', [
                                'parent' => Category::find($id),
                                'children' => Category::where('parent_id', $id)->exists() ?
                                                Category::where('parent_id', $id)->with(['discount'])->get()->transform(function($item) {
                                                    return [
                                                        'id' => $item->id,
                                                        'name' => $item->name,
                                                        'amount' => optional($item->discount)->amount
                                                    ];
                                                }) :
                                                Item::where('category_id', $id)->with(['discount'])->get()->transform(function($item) {
                                                    return [
                                                        'id' => $item->id,
                                                        'name' => $item->name,
                                                        'amount' => optional($item->discount)->amount
                                                    ];
                                                }),
                                'type' => Category::where('parent_id', $id)->exists() ? 'category' : 'item'
                            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = request()->input('type') == 'menu' ? 'App\Models\Menu' : (request()->input('type') == 'category' ? 'App\Models\Category' : 'App\Models\Item');

        return Inertia::render('Discount/Edit', [
                    'id' => $id,
                    'type' => request()->input('type'),
                    'discount' => Discount::where('discountable_type', $type)->where('discountable_id', $id)->first()
                ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $type = request()->input('type') == 'menu' ? 'App\Models\Menu' : (request()->input('type') == 'category' ? 'App\Models\Category' : 'App\Models\Item');

        $request->validate(['amount' => 'required']);

        $amount = $request->input('amount');

        DB::table('discounts')
            ->updateOrInsert(
                ['discountable_id' => $id, 'discountable_type' => $type],
                ['amount' => $amount]
            );

        return Redirect::route('discounts.index')->with('success', 'Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
