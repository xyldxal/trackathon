<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileAttachment;
use Illuminate\Support\Facades\Storage;

class FileAttachmentController extends Controller
{
    public function destroy(FileAttachment $file){
        if (!$file->file_path) {
            return redirect()->back()
                ->with('error', 'File path is missing');
        }
    
        // Verify file exists
        if (!Storage::disk('local')->exists($file->file_path)) {
            return redirect()->back()
                ->with('error', 'File not found in storage');
        }
    
        // Delete from storage
        Storage::disk('local')->delete($file->file_path);
        
        // Delete from database
        $file->delete();
    
        return redirect()->back()
            ->with('success', 'File deleted successfully');
    }
}
