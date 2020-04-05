<?php

namespace App\Repositories;

use App\User;
use App\Detail;

class DetailRepository extends Repository {

    public function __construct(Detail $detail = null)
    {
        $this->model = $detail ?: new Detail();
    }

    public function updateForUser(User $user, $values)
    {
        return $this->model->updateOrCreate(['user_id' => $user->id], $values);
    }
}
