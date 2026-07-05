<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::withCount('galleries')->orderBy('id', 'desc')->get();
        return response()->json(['data' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_categories,slug',
            'status' => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['status'] = $data['status'] ?? true;

        $category = GalleryCategory::create($data);
        return response()->json(['data' => $category], 201);
    }

    public function show(GalleryCategory $galleryCategory)
    {
        $galleryCategory->loadCount('galleries');
        return response()->json(['data' => $galleryCategory]);
    }

    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_categories,slug,' . $galleryCategory->id,
            'status' => 'boolean',
        ]);

        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $galleryCategory->update($data);
        return response()->json(['data' => $galleryCategory]);
    }

    public function destroy(GalleryCategory $galleryCategory)
    {
        $galleryCategory->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
