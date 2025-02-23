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
            ->subject(__('Event registration') . " - " . $this->order->fullOrderNumber)
            ->greeting(__('Hello, ') . $this->order->fullBillingName . '!')
            ->markdown("email.order.order-details", [
                'order' => $this->order,
                'event' => $this->event,
                'formSubmission' => $this->formSubmission,
                'content' => !empty($this->event->confirmation_email_content) ? new HtmlString($this->event->confirmation_email_content) : null,
            ]);

        if (!empty($attachments = $this->event->confirmation_email_attachments)) {
            foreach ($attachments as $attachment) {
                $message->attach($attachment->getPath(), [
                    'as' => $attachment->getName(),
                    'mime' => $attachment->mime_type,
                ]);
            }
        }

        return $message;
    }
}
