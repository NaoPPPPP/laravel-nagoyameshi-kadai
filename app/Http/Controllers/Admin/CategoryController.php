<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Category::query();

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");                
        }

        $categories = $query->paginate(15);

        $total = $categories->total();

        return view('admin.categories.index', compact('categories', 'keyword', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを登録しました。');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを編集しました。');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを削除しました。');
    }
}
