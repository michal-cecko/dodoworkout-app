<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\FormSubmission;
use App\Models\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderCreated extends Notification
{
    protected Event $event;

    /**
     * Create a new notification instance.
     * @throws Exception
     */
    public function __construct(Event|int $event, protected Order $order, protected ?FormSubmission $formSubmission){
        if(is_int($event)) {
            $this->event = Event::find($event);
            if(!$this->event) {
                throw new Exception("Event not found: " . $event);
            }
        } else {
            $this->event = $event;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        $message = (new MailMessage)
            ->subject(__('ord_email_subject') . " - " . $this->order->fullOrderNumber)
            ->markdown("email.order.order-details", [
                'order' => $this->order,
                'event' => $this->event,
                'formSubmission' => $this->formSubmission,
            ]);

        $attachments = $this->event->getMedia("confirmation_email_attachments");
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $message->attach($attachment->getPath(), [
                    'as' => $attachment->file_name,
                    'mime' => $attachment->mime_type,
                ]);
            }
        }

        return $message;
    }
}
