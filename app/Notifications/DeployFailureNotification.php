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
    public function __construct(Site $site)
    {
        //
        $this->site = $site;
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
                    ->line($this->site->name)
                    ->line('متاسفانه در فرآیند دپلوی سایت test مشکلی به وجود آمده است.
متن خطا به شرح زیر می باشد:.')
                    ->line('failed to clone repository from git')
                    ->line('برای دیدن جزئیات بیشتر روی دکمه زیر کلیک کنید')
                    ->action('نمایش گزارش دپلوی', url(route('sites.deployments', ['id'=>$this->site->id])));

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
