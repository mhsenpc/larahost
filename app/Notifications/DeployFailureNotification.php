<?php

namespace App\Notifications;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeployFailureNotification extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $site;
    protected $message;

    public function __construct(Site $site, string $message) {
        //
        $this->site = $site;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject(__('email.deploy_failed.subject'))
            ->greeting(__('email.deploy_failed.email-deploy-hello'))
            ->line(__('email.deploy_failed.primary-title', ['name' => $this->site->user->name]))
            ->line(__('email.deploy_failed.error-deploy', ['site' => $this->site->name]))
            ->line($this->message)
            ->line(__('email.deploy_failed.error-deploy-more'))
            ->action(__('email.deploy_failed.deploy-view-report'), route('sites.deployments', ['site' => $this->site]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [

        ];
    }
}
