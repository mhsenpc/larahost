<?php

namespace App\Notifications;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeployFailureNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $site;
    protected $message;
    public function __construct(Site $site,string $message)
    {
        //
        $this->site = $site;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                     ->greeting(__('email.email-hello'))
                    ->line(__('email.welcome-title',['name' => $this->site->name]))
                    ->line(__('email.errorr-deploy'))
                    ->line(__('email.failed-to-clone-git',['message' => $this->message]))
                    ->line(__('email.errorr-deploy-more'))
                    ->action(__('email.deploy-view-report'), route('sites.deployments', ['site'=>$this->site]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
