<!DOCTYPE html>
<html>
<head>
    <style>[x-cloak] { display: none !important; }</style>
    <title>Todo App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <livewire:todo-list />

    @livewireScripts
</body>
</html>