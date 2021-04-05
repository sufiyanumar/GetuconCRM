<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileAttachmentController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        try {
            $data = [];
            $i = 0;
            $type = $request->type;
            if ($type == 'single') {
                $file = $request->file('file');
                $fileOriginalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $fileNameToStore = $fileOriginalName . '_' . time() . '.' . $extension;
                $filename = $file->storeAs('public/uploadsnew/attach', $fileNameToStore);
                $data['name'] = $fileOriginalName;
                $data['link'] = $fileNameToStore;
                $data['size'] = $size;
                return ['success' => 'File uploaded successfully', 'data' => $data];
            } else {
                $files = $request->file('file');
                if (!$files)
                    return ['error' => 'Please attach at least one file'];
                foreach ($files as $file) {
                    $fileOriginalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $fileNameToStore = $fileOriginalName . '_' . time() . '.' . $extension;
                    $filename = $file->storeAs('public/uploadsnew/attach', $fileNameToStore);
                    $data[$i]['name'] = $fileOriginalName;
                    $data[$i]['link'] = $fileNameToStore;
                    $data[$i]['size'] = $size;
                    $i++;
                }
                return ['success' => 'File uploaded successfully', 'data' => $data];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
            return ['error' => 'Something went wrong'];
        }
    }
}
