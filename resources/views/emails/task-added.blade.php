<x-mail::message>
# New Task Added

You just added a new task to your Todo list:

**{{ $todo->title }}**

<x-mail::button :url="route('todos')">
View Your Todos
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>