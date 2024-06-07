<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShareTableNotification extends Notification
{
    use Queueable;

    protected $table;
    protected $message;
    protected $userName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($table, $message, $userName)
    {
        $this->table = $table;
        $this->message = $message;
        $this->userName = $userName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Table Shared: ' . str_replace('_', ' ', $this->table))
                ->greeting('Hello!')
                ->line('Your friend ' . $this->userName . ' has shared the table ' . str_replace('_', ' ', $this->table) . ' with you.')
                ->line('To view it, join us by clicking the following link:')
                ->action('Join Us', url('register'))
                ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
