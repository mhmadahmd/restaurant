<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Menu/Index', [
            'menus' => Menu::where('user_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Menu/Create', [
            'users' => User::whereHas('roles', function ($q) {
                $q->where('name', 'restaurant-admin');
            })->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'admin_rest_id' => 'required'
        ]);
        $inputs = $request->all();
        $inputs['user_id'] = Auth::user()->id;
        Menu::create($inputs);

        return to_route('menus.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return Redirect::route('menus.index')->with('success', 'Deleted Successfully');
    }
}
