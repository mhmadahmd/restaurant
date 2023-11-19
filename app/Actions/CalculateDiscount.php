<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Discount;
use Lorisleiva\Actions\Concerns\AsAction;

class CalculateDiscount
{
    use AsAction;

    public function handle($id, $type)
    {
        if($type == 'menu') {
            return Category::where('menu_id', $id)->WhereNull('parent_id')->with(['discount'])->get()->transform(function ($item) use ($id) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'amount' => empty($item->discount) ?
                        optional($item->discount = Discount::where('discountable_id', $id)->where('discountable_type', 'App\Models\Menu')->first())->amount :
                        $item->discount->amount
                ];
            });
        } else {
            // Category::where('parent_id', $id)->exists() ?  : Item::where('category_id', $id)->with(['discount'])->get()
            // Category
            if(Category::where('parent_id', $id)->exists()) {
                // dd(Category::tree(4)->get());
                return Category::where('parent_id', $id)->with(['discount', 'parent.discount'])->get()->transform(function ($item) use ($id) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => empty($item->discount) ?
                            optional($item->discount = Discount::where('discountable_id', $id)->where('discountable_type', 'App\Models\Menu')->first())->amount :
                            $item->discount->amount
                    ];
                });
            }
        }
    }
}
