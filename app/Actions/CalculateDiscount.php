<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Item;
use App\Models\Menu;
use Lorisleiva\Actions\Concerns\AsAction;

class CalculateDiscount
{
    use AsAction;

    public function handle($id, $type)
    {
        if($type == 'menu') {

            $has_discount = Category::has('discount')->find($id);

            if($has_discount) {
                return $has_discount->discount->amount;
            } else {
                $category = Category::find($id);
                $menu = Menu::with(['discount'])->find($category->menu_id);

                if(!empty(Category::isRoot()->find($id))) {
                    return optional($menu->discount)->amount;
                } else {
                    foreach($category->ancestors as $ancestor) {
                        if(!empty($ancestor->discount)) {
                            return $ancestor->discount->amount;
                        }
                    }
                }

                return optional($menu->discount)->amount;

            }
        } else {
            $has_discount = Item::has('discount')->find($id);

            if($has_discount) {
                return $has_discount->discount->amount;
            } else {
                $item = Item::find($id);
                $parent = Category::with(['discount'])->find($item->category_id);
                $menu = Menu::with(['discount'])->find($parent->menu_id);

                if(!empty($parent->discount)){
                    return $parent->discount->amount;
                } else {
                    if(empty($parent->parent_id)){
                        return optional($menu->discount)->amount;
                    } else {
                        foreach($parent->ancestors as $ancestor) {
                            if(!empty($ancestor->discount)) {
                                return $ancestor->discount->amount;
                            }
                        }

                    }
                }
                return optional($menu->discount)->amount;
            }

        }
    }
}
