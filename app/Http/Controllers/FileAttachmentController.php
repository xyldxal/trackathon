<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileAttachment;
use Illuminate\Support\Facades\Storage;

class FileAttachmentController extends Controller
{
    public function destroy(FileAttachment $file){
        Storage::disk('local')->delete($file->path);
        $file->delete();
        return redirect()->back();
    }
}
