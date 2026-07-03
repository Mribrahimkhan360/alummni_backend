<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function latest()
    {
        $notices = Notice::active()->latest()->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => $notices,
        ]);
    }

    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $notices = Notice::latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $notices->items(),
            'meta' => [
                'current_page' => $notices->currentPage(),
                'last_page' => $notices->lastPage(),
                'per_page' => $notices->perPage(),
                'total' => $notices->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $notice,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'full_content' => 'nullable|string',
            'date' => 'nullable|string|max:10',
            'month' => 'nullable|string|max:10',
            'year' => 'nullable|string|max:10',
            'category' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'nullable|string|max:255',
            'deadline' => 'nullable|string|max:255',
            'cta_label' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notices', 'public');
        }
        $data['image'] = $imagePath;

        $notice = Notice::create($data);

        return response()->json([
            'message' => 'Notice created successfully',
            'data' => $notice,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'full_content' => 'nullable|string',
            'date' => 'nullable|string|max:10',
            'month' => 'nullable|string|max:10',
            'year' => 'nullable|string|max:10',
            'category' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'nullable|string|max:255',
            'deadline' => 'nullable|string|max:255',
            'cta_label' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($notice->image) {
                Storage::disk('public')->delete($notice->image);
            }
            $data['image'] = $request->file('image')->store('notices', 'public');
        }

        $notice->update($data);

        return response()->json([
            'message' => 'Notice updated successfully',
            'data' => $notice,
        ]);
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->image) {
            Storage::disk('public')->delete($notice->image);
        }

        $notice->delete();

        return response()->json([
            'message' => 'Notice deleted successfully',
        ]);
    }
}
