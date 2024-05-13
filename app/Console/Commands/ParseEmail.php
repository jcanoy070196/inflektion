<?php

namespace App\Console\Commands;

use App\Actions\SuccessfulEmails\CreateSuccessfulEmailAction;
use App\Http\Requests\SuccessfulEmails\CreateSuccessfulEmailRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses HTML Email Content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $request = new CreateSuccessfulEmailRequest();

        $request->merge([
            'email' => $this->argument('email'),
        ]);

        $email = (new CreateSuccessfulEmailAction())->execute($request);

        echo "Record has been parsed and stored.\nID: " .  $email->id;
    }
}
