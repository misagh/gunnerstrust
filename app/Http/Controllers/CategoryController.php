<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;

class CategoryController extends Controller {

    public function updates($slug)
    {
        $category = (new CategoryRepository)->findByOrFail('slug', $slug);

        $updates = (new CategoryRepository($category))->getLatestUpdates();

        return view('categories.updates', compact('category', 'updates'));
    }
}
