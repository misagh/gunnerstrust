<?php

namespace App\Repositories;

use App\Team;

class TeamRepository extends Repository {

    public function __construct(Team $team = null)
    {
        $this->model = $team ?: new Team();
    }

    public function insertTeam($data)
    {
        return $this->create($data);
    }

    public function updateTeam($data)
    {
        $this->update($this->model, $data);

        return $this->model;
    }

    public function getTeamNameFa($id)
    {
        return $this->findOrFail($id)->name_fa;
    }

    public function getAllTeams()
    {
        return $this->model->orderBy('name_en')
                           ->get();
    }
}
