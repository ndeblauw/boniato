<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::find($id);

        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
        ]);

        Category::create($validated);

        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Data aspects
        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
        ]);

        // return a response
        return redirect('/categories');
    }

    public function destroy($id)
    {
        // data aspects
        $category = Category::find($id);
        $category->delete();

        // return a response
        return redirect('/categories');
    }
}
