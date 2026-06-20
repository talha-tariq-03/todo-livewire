<?php

namespace App\Jobs;

use App\Mail\TaskReminderMail;
use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskReminderEmail implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public Todo $todo;
    public string $email;

    public function __construct(Todo $todo, string $email)
    {
        $this->todo = $todo;
        $this->email = $email;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new TaskReminderMail($this->todo));
    }
}