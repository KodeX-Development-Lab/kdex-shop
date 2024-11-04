<?php

namespace App\Services\Admin;

use App\Models\Category;

class CategoryService
{
    public function all()
    {

    }

    public function get($id)
    {
        $category = Category::findOrFail($id);

        return $category;
    }

    public function store($request, $user)
    {
        $category = Category::create([
            'name'       => $request->name,
            'created_by' => $user->id,
        ]);
    }

    public function update($id, $request, $user)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name'       => $request->name,
            'updated_by' => $user->id,
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return true;
    }
}
