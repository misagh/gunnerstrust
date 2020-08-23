<?php

namespace App\Repositories;

use App\Partner;

class PartnerRepository extends Repository {

    public function __construct(Partner $partner = null)
    {
        $this->model = $partner ?: new Partner();
    }

    public function getArticles()
    {
        return $this->model->articles()
                           ->orderByDesc('id')
                           ->get();
    }
}
