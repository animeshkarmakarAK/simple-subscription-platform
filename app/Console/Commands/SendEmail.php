<?php

namespace App\Console\Commands;

use App\Mail\PostMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to subscribers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $title = $this->ask('post title?');
        $body = $this->ask('post body?');
        $receiver = $this->ask('receiver email?');

        Mail::to($receiver)->send(New PostMail($title, $body));

        $this->info('The email are send successfully!');
        return 0;
    }
}
