<?php

namespace App\Domain\Shop\Notifications;

use App\Domain\Shop\Models\License;
use App\Http\Controllers\ProductsController;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseIsAboutToExpireNotification extends Notification
{
    use Queueable;

    private License $license;

    public function __construct(License $license)
    {
        $this->license = $license;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $name = $this->license->getName();

        $siteUrl = url('/');

        return (new MailMessage)
            ->subject("Your {$name} license is about to expire")
            ->greeting('Hi!')
            ->line("Your {$name} license expires on {$this->license->expires_at->format('Y-m-d')}.")
            ->line("Go to your license overview on the [spatie.be]({$siteUrl}) site to renew the license and continue receiving updates.")
            ->line(Markdown::parse($this->license->assignment->purchasable->renewal_mail_incentive))
            ->action('Renew now', action([ProductsController::class, 'show'], $this->license->assignment->purchasable->product))
            ->line("Thank you for using {$this->license->assignment->purchasable->product->title}!");
    }
}
