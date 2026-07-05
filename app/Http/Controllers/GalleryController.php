<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')->orderBy('id', 'desc')->get();
        return response()->json(['data' => $galleries]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('galleries', 'public');
        }

        $data['status'] = $data['status'] ?? true;

        $gallery = Gallery::create($data);
        $gallery->load('category');

        return response()->json(['data' => $gallery], 201);
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('category');
        return response()->json(['data' => $gallery]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'gallery_category_id' => 'sometimes|exists:gallery_categories,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($data);
        $gallery->load('category');

        return response()->json(['data' => $gallery]);
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return response()->json(['message' => 'Gallery item deleted']);
    }

    public function byCategory($categoryId)
    {
        $galleries = Gallery::where('gallery_category_id', $categoryId)
            ->where('status', true)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(['data' => $galleries]);
    }
}
