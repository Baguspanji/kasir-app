<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'file' => 'max:10000|mimes:doc,docx,xlsx,xls,pdf,jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()], 400);
        }

        $file_dir = 'public/' . $request->type . '/';

        if ($request->header("-method") == "DELETE") {
            $url = URL::to('/');
            $filename = $request->post('image');
            $path = $file_dir . '/' . $filename;

            return array(
                'message' => "file deleted",
                'status' => Storage::delete($path),
            );
        } else {
            if ($request->hasFile('file')) {

                $image = $request->file('file');
                // $filename = $image->getClientOriginalName();
                $image_uploaded = $image->store($file_dir);

                $url = Storage::url($image_uploaded);

                return $url;
            }

            return '';
        }
    }
}
