<?php

namespace App\Actions\SuccessfulEmails;

use App\Actions\Helpers\ParseEmailAction;
use App\Http\Requests\SuccessfulEmails\UpdateSuccessfulEmailRequest;
use App\Models\SuccessfulEmail;

class UpdateSuccessfulEmailAction {

    public function execute(
        UpdateSuccessfulEmailRequest $request,
        SuccessfulEmail $model,
    ): SuccessfulEmail
    {
        $rawText = (new ParseEmailAction())->execute($request->email);

        $model->email = $request->email;
        $model->raw_text = $rawText;

        $model->save();

        return $model;
    }
}