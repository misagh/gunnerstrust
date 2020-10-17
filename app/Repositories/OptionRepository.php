<?php

namespace App\Repositories;

use App\Option;

class OptionRepository extends Repository {

    public function __construct(Option $option = null)
    {
        $this->model = $option ?: new Option();
    }
}
