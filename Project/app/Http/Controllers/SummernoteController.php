<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SummernoteController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:500',
            'contentType' => 'nullable|string'
        ]);

        $contentType = $validated['contentType'] ?? 'general';

        $allowedTypes = ['general', 'news', 'articles', 'projects'];

        if (!in_array($contentType, $allowedTypes)) {
            abort(403, 'invalid content type.');
        }

        if ($request->hasFile('image'))
        {
            $image = $validated['image'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs("public/uploads/{$contentType}", $filename);

            $url = Storage::url($path);
            return response($url, 200);
        }

        return response('No image uploaded', 400);
    }
}
