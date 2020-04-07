<?php

namespace App\Http\Controllers;

use App\Services\ArticleImageFinder;

class AdminController extends Controller {

    public function articlesOptimize()
    {
        $dir = glob(storage_path('app/covers/*/*'));

        foreach ($dir as $img)
        {
            (new ArticleImageFinder)->optimize($img);
        }
    }
}
