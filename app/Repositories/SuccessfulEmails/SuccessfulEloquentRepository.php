<?php

namespace App\Repositories\SuccessfulEmails;

use App\Models\SuccessfulEmail;
use App\Repositories\BaseRepositoryEloquent;

class SuccessfulEloquentRepository extends BaseRepositoryEloquent implements SuccessfulRepositoryInterface 
{
    public function __construct(SuccessfulEmail $successfulEmail)
    {
        parent::__construct($successfulEmail);
    }
}