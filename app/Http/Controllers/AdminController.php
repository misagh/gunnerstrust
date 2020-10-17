<?php

namespace App\Http\Controllers;

use App\Services\ArticleImageFinder;

class AdminController extends Controller {

    public function index()
    {
        return view('admin.index');
    }

    public function upload()
    {
        if (request()->isMethod('post') && $file = request()->file('file'))
        {
            $file_name = sha1(time()) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $file_name);

            $mimes = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];

            if (in_array($file->getMimeType(), $mimes))
            {
                (new ArticleImageFinder)->optimize(storage_path('app/uploads/' . $file_name), 728);
            }
        }

        $images = glob(storage_path('app/uploads/*'));

        return view('admin.upload', compact('images'));
    }

    public function articlesOptimize()
    {
        $dir = glob(storage_path('app/covers/*/*'));

        foreach ($dir as $img)
        {
            (new ArticleImageFinder)->optimize($img);
        }
    }
}
