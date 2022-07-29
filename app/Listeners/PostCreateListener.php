<?php

namespace App\Listeners;

use App\Events\PostCreateEvent;
use App\Mail\PostMail;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PostCreateListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PostCreateEvent $event
     * @return void
     */
    public function handle(PostCreateEvent $event)
    {
        $websiteId = $event->websiteId;
        $postBody = $event->postBody;
        $postTitle = $event->postTitle;

        $website = Website::findOrFail($websiteId);
        $subscribers = $website->users;

        foreach($subscribers as $user) {
            Mail::to($user->email)->send(new PostMail($postTitle, $postBody));
        }
    }
}
