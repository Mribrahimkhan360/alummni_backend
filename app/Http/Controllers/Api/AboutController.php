<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Http\Requests\AboutRequest;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function index()
    {
        return response()->json(About::latest()->get());
    }

    public function store(AboutRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image_secondary')) {
            $data['image_secondary'] = $this->uploadImage($request);
        }

        $about = About::create($data);

        return response()->json($about, 201);
    }

    public function show(About $about)
    {
        return response()->json($about);
    }

    public function update(AboutRequest $request, About $about)
    {
        $data = $request->validated();

        if ($request->hasFile('image_secondary')) {
            $this->deleteImage($about->image_secondary);
            $data['image_secondary'] = $this->uploadImage($request);
        }

        $about->update($data);

        return response()->json($about);
    }

    public function destroy(About $about)
    {
        $this->deleteImage($about->image_secondary);

        $about->delete();

        return response()->json([
            'message' => 'Deleted Successfully',
        ]);
    }

    /**
     * Handle image upload, creating the target folder if it doesn't exist.
     */
    private function uploadImage($request): string
    {
        $directory = public_path('uploads/about');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $file = $request->file('image_secondary');
        $name = time() . '_' . $file->getClientOriginalName();
        $file->move($directory, $name);

        return 'uploads/about/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}