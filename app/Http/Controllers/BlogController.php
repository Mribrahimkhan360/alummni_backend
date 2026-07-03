<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function latest()
    {
        $blogs = Blog::active()->latest()->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => $blogs,
        ]);
    }

    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $blogs = Blog::latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $blogs->items(),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $blog,
        ]);
    }

    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }
        $data['image'] = $imagePath;

        $blog = Blog::create($data);

        return response()->json([
            'message' => 'Blog created successfully',
            'data' => $blog,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'excerpt'        => 'nullable|string',
            'full_content'   => 'nullable|string',
            'category'       => 'nullable|string|max:50',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author'         => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'read_time'      => 'nullable|string|max:20',
            'is_active'      => 'nullable|boolean',
            'published_at'   => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return response()->json([
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully',
        ]);
    }
}
