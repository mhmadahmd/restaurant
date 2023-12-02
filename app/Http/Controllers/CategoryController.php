<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Menu;
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
        $menu = request()->input('m');
        $constraint = function ($query) use ($menu) {
            $query->whereNull('parent_id')->where('menu_id', $menu);
        };
        $tree = Category::with(['discount', 'items'])->treeOf($constraint)->get();

        return Inertia::render('Category/Index', [
            'tree' => $tree->toTree()->toArray(),
            'menu' => Menu::find($menu)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = Menu::find(request()->input('m'));
        abort_if(empty($menu), 404);

        $query = Category::where('menu_id', $menu->id)->tree(2)->doesntHave('items')->get();
        return Inertia::render('Category/Create', [
            'categories' => $query->toArray(),
            'menu_id' => $menu->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                    'name' => 'required',
                    'menu_id' => 'required',
                ]);
        $inputs = $request->all();

        $category = Category::create($inputs);

        return Redirect::route('categories.index', ['m' => $inputs['menu_id']])->with(
            [
                'success' => 'Created Successfully'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::find($category->id)->descendantsAndSelf()->delete();
        return Redirect::route('categories.index', ['m' => $category->menu_id])->with('success', 'Deleted Successfully');
    }
}
