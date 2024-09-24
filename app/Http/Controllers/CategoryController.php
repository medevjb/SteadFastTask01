<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Container\Attributes\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('layouts.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request['name'],
            'slug' => Str::slug($request['name']),
            'description' => $request['description'],
            'user_id' => auth()->id(),
        ]);
        flash()->success('Category created successfully');
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $category = Category::where('slug', $slug)->where('user_id', auth()->id())->first();
        return view('layouts.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::where('slug', $slug)->where('user_id', auth()->id())->first();
        $category->update([
            'name' => $request['name'],
            'slug' => Str::slug($request['name']),
            'description' => $request['description'],
        ]);
        flash()->success('Category updated successfully');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if($category){
            $category->delete();
            flash()->success('Category deleted successfully');
            return redirect()->route('categories.index');
        }else{
            flash()->error('Category not found');
            return redirect()->route('categories.index');
        }
    }
}
