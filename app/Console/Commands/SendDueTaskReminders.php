<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Jobs\SendTaskReminderEmail;
use Illuminate\Console\Command;

class SendDueTaskReminders extends Command
{
    protected $signature = 'todos:send-reminders';
    protected $description = 'Send email reminders for todos that are now due';

    public function handle(): void
    {
        $dueTodos = Todo::where('completed', false)
            ->where('reminder_sent', false)
            ->whereNotNull('due_at')
            ->where('due_at', '<=', now())
            ->get();

        $this->info("Found {$dueTodos->count()} due task(s).");

        foreach ($dueTodos as $todo) {
        $this->info('Queue connection: ' . config('queue.default'));
        SendTaskReminderEmail::dispatch($todo, $todo->user->email);
        $todo->update(['reminder_sent' => true]);
        $this->info("Reminder queued for: {$todo->title}");
    }
    }
}