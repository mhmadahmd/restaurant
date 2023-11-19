<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Category/Create', [
                    'menu_id' => request()->input('menu_id'),
                    'parent_id' => request()->input('parent_id'),
                ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                    'name' => 'required',
                ]);
        $inputs = $request->all();
        if(empty($request->input('menu_id'))){
            $inputs['menu_id'] = Category::find($request->input('parent_id'))->menu_id;
        }
        Category::create($inputs);

        return Redirect::route('categories.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
// dd(Category::where('id', $category->id)->has('parent.parent.parent')->get());
        return Inertia::render('Category/Show', [
                    'category' => $category,
                    'subcategories' => Category::where('parent_id', $category->id)->get(),
                    'can' => [
                        'create_items' => Category::where('parent_id', $category->id)->doesntExist(),
                        'create_subcategories' => Category::where('id', $category->id)->has('parent.parent.parent')->doesntExist(),
                    ]
                ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return Redirect::route('menus.index')->with('success', 'Deleted Successfully');
    }
}
