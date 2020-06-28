<?php

namespace App\Repositories;

use App\Stadium;

class StadiumRepository extends Repository {

    public function __construct(Stadium $stadium = null)
    {
        $this->model = $stadium ?: new Stadium();
    }

    public function insertStadium($data)
    {
        return $this->create($data);
    }

    public function updateStadium($data)
    {
        $this->update($this->model, $data);

        return $this->model;
    }

    public function getAllStadiums()
    {
        return $this->model->orderBy('name_en')
                           ->get();
    }
}
