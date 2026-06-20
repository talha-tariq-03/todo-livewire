<?php

namespace App\Mail;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAddedMail extends Mailable
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
            subject: 'New Task Added: ' . $this->todo->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.task-added',
        );
    }
}