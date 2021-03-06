<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Discussion;

class NewReplyAdded extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * the reply discussion
     *
     * @var Discussion
     */
//--------------------------------------------------------------------------
//                          Notification
//--------------------------------------------------------------------------

    public $discussion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //if only mail it will use the toMail() function,
        //so, put 
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new reply was added to your discussion')
                    ->action('View Discussion', route('discussions.show', $this->discussion->slug))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {   
        //you can save an array in the notification record that contains what you want,
        //.. here i decide to send the whole notification instead of sending ids or message
        return [
            'discussion' => $this->discussion
        ];
    }
}
