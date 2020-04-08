<?php

namespace App\Http\Controllers;

use App\Services\ArticleImageFinder;

class AvatarController extends Controller {

    public function add()
    {
        $user = auth()->user();

        if ($avatar = request()->avatar)
        {
            $file_name = substr(sha1($user->id . time()), 0, 15);
            $dir = 'avatars/' . substr($file_name, 0, 2);
            $path = storage_path('app/' . $dir . '/' . $file_name . '.png');

            $avatar->storeAs($dir, $file_name . '.png');

            (new ArticleImageFinder)->optimize($path, 200, 200);

            $avatars = $user->avatars;

            if ($avatars->isNotEmpty())
            {
                foreach ($avatars as $avatar)
                {
                    $file = $avatar->file_name;
                    $folder = substr($file, 0, 2);

                    @unlink(storage_path('app/avatars/' . $folder . '/' . $file . '.png'));
                    @rmdir(storage_path('app/avatars/' . $folder));

                    $avatar->delete();
                }
            }

            $user->avatars()->create(compact('file_name'));
        }

        session()->flash('success', 'آواتار شما با موفقیت ذخیره شد.');

        return response(['status' => 'success']);
    }
}
