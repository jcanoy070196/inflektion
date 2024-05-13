<?php

namespace App\Actions\SuccessfulEmails;

use App\Models\SuccessfulEmail;

class DeleteSuccessfulEmailAction {

    public function execute(
        SuccessfulEmail $model,
    ): bool
    {
        return $model->delete();
    }
}