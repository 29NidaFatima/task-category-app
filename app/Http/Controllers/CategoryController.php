<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // READ
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    // EDIT PAGE
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // UPDATE
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect('/categories');
    }

    // DELETE
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
