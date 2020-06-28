<?php

namespace App\Repositories;

use App\Competition;

class CompetitionRepository extends Repository {

    public function __construct(Competition $competition = null)
    {
        $this->model = $competition ?: new Competition();
    }

    public function getAllCompetitions()
    {
        return $this->model->orderBy('name_en')
                           ->get();
    }
}
