<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::find($id);

        return view('admin.categories.show', compact('category'));
    }

    public function create()
    {
        return view('admin.categories.create');
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

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
        ]);

        // Data aspects
        $category = Category::find($id);
        $category->update($validated);

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
