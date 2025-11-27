<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\User;
use App\Notifications\ArticlePublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class InformAdminsOfNewPublicationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Article $article,
        public User $publisher,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(10);


        $admins = User::where('is_admin', true)->get();
        foreach($admins as $admin) {
            $admin->notify(new ArticlePublishedNotification($this->article, $this->publisher));
        }
    }
}
