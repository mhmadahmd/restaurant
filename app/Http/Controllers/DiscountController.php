<?php

namespace App\Http\Controllers;

use App\Actions\CalculateDiscount;
use App\Http\Requests\UpdateDiscountRequest;
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
     * Display the specified resource.
     */
    public function show($id)
    {
        if(request()->input('type') == 'menu') {
            return Inertia::render('Discount/Show', [
                        'parent' => Menu::find($id),
                        'children' => Category::where('menu_id', $id)->WhereNull('parent_id')->with(['discount'])->get()->transform(function ($item) use ($id) {
                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => CalculateDiscount::run($item->id, request()->input('type'))
                            ];
                        }),
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
                                                        'amount' => CalculateDiscount::run($item->id, 'menu')
                                                    ];
                                                }) :
                                                Item::where('category_id', $id)->with(['discount'])->get()->transform(function($item) {
                                                    return [
                                                        'id' => $item->id,
                                                        'name' => $item->name,
                                                        'amount' => CalculateDiscount::run($item->id, 'item')
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
    public function update(UpdateDiscountRequest $request, $id)
    {
        $type = request()->input('type') == 'menu' ? 'App\Models\Menu' : (request()->input('type') == 'category' ? 'App\Models\Category' : 'App\Models\Item');

        $data = $request->validated();

        DB::table('discounts')
            ->updateOrInsert(
                ['discountable_id' => $id, 'discountable_type' => $type],
                ['amount' => $data['amount']]
            );

        return Redirect::route('discounts.index')->with('success', 'Updated Successfully');

    }
}
