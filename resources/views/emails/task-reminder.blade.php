<x-mail::message>
# Task Due Now ⏰

Your task is due:

**{{ $todo->title }}**

Due: {{ $todo->due_at->format('M j, Y g:i A') }}

<x-mail::button :url="$completeUrl">
Mark as Complete
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>