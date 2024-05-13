<?php

namespace App\Repositories\SuccessfulEmails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SuccessfulRepositoryInterface 
{
    public function get($columns = ['*']): Collection;

    public function find(int $id): ?Model;
}