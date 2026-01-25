<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticlePublishedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Article $article, public User $publisher) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Article - waaaw, we keep on growing')
            ->greeting('Hejsa '.$notifiable->name.',')
            ->line("<strong>{$this->article->title}</strong> has been published by <strong>{$this->publisher->name}</strong>.")
            ->action('Go and read it here', 'http://boniato.test/articles/'.$this->article->id)
            ->line('Thank you for using our application!')
            ->salutation('Adios, ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
