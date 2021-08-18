<?php

namespace App\Services\Administration;

use App\Models\Administration\File;
use Illuminate\Support\Facades\Storage;

class FilesService
{
    public function store($request)
    {
        $path = $request->file('file')->store('files'); 
        
        $file  = File::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'mime_type' => $request->file('file')->getMimeType(),
            'extension' => $request->file('file')->extension(),
            'size' => $request->file('file')->getSize(),
            'url' => Storage::url($path)
        ]);

        return $file;
    }
}