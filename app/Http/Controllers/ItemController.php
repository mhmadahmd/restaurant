<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = request()->input('c');
        return Inertia::render('Item/Index', [
            'list' => Item::where('category_id', $cat)->get(),
            'category' => Category::find($cat)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::isLeaf()->find(request()->input('c'));
        abort_if(empty($category), 404, "Requested Category Not Found");

        return Inertia::render('Item/Create', [
                    'category_id' => $category->id,
                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Item::create($request->validate([
                            'name' => 'required',
                            'category_id' => 'required'
                        ]));
        return Redirect::route('items.index', ['c' => $request->input('category_id')])->with('success', 'Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $id = $item->category_id;
        $item->delete();
        return Redirect::route('items.index', ['c' => $id])->with('success', 'Deleted Successfully');

    }
}
