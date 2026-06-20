<x-mail::message>
# New Task Added

You just added a new task to your Todo list:

**{{ $todo->title }}**

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>