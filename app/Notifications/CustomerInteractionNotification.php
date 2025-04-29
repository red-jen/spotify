<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Design;
use App\Models\User;

class CustomerInteractionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $interaction;
    protected $design;
    protected $customer;
    protected $interactionType;

    /**
     * Create a new notification instance.
     *
     * @param string $interactionType
     * @param mixed $interaction
     * @param Design $design
     * @param User $customer
     * @return void
     */
    public function __construct($interactionType, $interaction, Design $design, User $customer)
    {
        $this->interactionType = $interactionType;
        $this->interaction = $interaction;
        $this->design = $design;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        $mailMessage = (new MailMessage)
            ->subject("New $this->interactionType on Your Design")
            ->greeting("Hello $notifiable->name,")
            ->line("You have a new $this->interactionType on your design '\{$this->design->title\}'.");
            
        switch ($this->interactionType) {
            case 'review':
                $mailMessage->line("Rating: {$this->interaction->rating} stars")
                    ->line("Comment: {$this->interaction->comment}");
                break;
                
            case 'question':
                $mailMessage->line("Question: {$this->interaction->content}");
                break;
                
            case 'purchase':
                $mailMessage->line("Order #: {$this->interaction->order_number}")
                    ->line("Amount: ${$this->interaction->total}");
                break;
        }
        
        return $mailMessage
            ->action('View Details', url("/designer/designs/{$this->design->id}/interactions"))
            ->line('Thank you for using our platform!');
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
            'interaction_type' => $this->interactionType,
            'design_id' => $this->design->id,
            'design_title' => $this->design->title,
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'interaction_id' => $this->interaction->id,
            'created_at' => now()->toIso8601String(),
        ];
    }
}
