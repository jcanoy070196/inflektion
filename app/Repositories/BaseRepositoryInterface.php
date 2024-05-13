<?php

 namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

 interface BaseRepositoryInterface 
 {
    public function model(): Model;
    
    public function get($columns = ['*']): Collection;

    public function find(int $id): ?Model;
 }