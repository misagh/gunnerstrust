<?php

namespace App\Repositories;

use App\User;

class UserRepository extends Repository {

    public function __construct(User $user = null)
    {
        $this->model = $user ?: new User();
    }

    public function findByUsername($username)
    {
        return $this->findByOrFail('username', $username);
    }

    public function getList()
    {
        return $this->model->orderByDesc('seen_at')
                           ->paginate(static::PAGINATION_LIMIT * 2);
    }
}
