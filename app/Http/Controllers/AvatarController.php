<?php

namespace App\Http\Controllers;

class AvatarController extends Controller {

    public function add()
    {
        $user = auth()->user();

        if ($avatar = request()->avatar)
        {
            $file_name = substr(sha1($user->id . time()), 0, 15);

            $avatar->storeAs('avatars/' . substr($file_name, 0, 2), $file_name . '.png');

            $avatars = $user->avatars;

            if ($avatars->isNotEmpty())
            {
                foreach ($avatars as $avatar)
                {
                    $file = $avatar->file_name;
                    $folder = substr($file, 0, 2);

                    unlink(storage_path('app/avatars/' . $folder . '/' . $file . '.png'));
                    rmdir(storage_path('app/avatars/' . $folder));

                    $avatar->delete();
                }
            }

            $user->avatars()->create(compact('file_name'));
        }

        session()->flash('success', 'آواتار شما با موفقیت ذخیره شد.');

        return response(['status' => 'success']);
    }
}
