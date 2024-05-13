<?php

namespace App\Actions\SuccessfulEmails;

use App\Actions\Helpers\ParseEmailAction;
use App\Http\Requests\SuccessfulEmails\CreateSuccessfulEmailRequest;
use App\Models\SuccessfulEmail;

class CreateSuccessfulEmailAction {

    public function execute(CreateSuccessfulEmailRequest $request): SuccessfulEmail
    {
        $rawText = (new ParseEmailAction())->execute($request->email);

        return SuccessfulEmail::create([
            'email' => $request->email,
            'raw_text' => $rawText,
        ]);
    }
}