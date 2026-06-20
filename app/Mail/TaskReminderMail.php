<?php

namespace App\Mail;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TaskReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Todo $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏰ Reminder: ' . $this->todo->title,
        );
    }

    public function content(): Content
    {
        $completeUrl = URL::signedRoute('todos.complete', ['todo' => $this->todo->id]);

    return new Content(
        markdown: 'emails.task-reminder',
        with: ['completeUrl' => $completeUrl],
    );
    }
}