<div
    x-data="{
        toast: { show: false, message: '', type: 'success' },
        showToast(message, type) {
            this.toast = { show: true, message, type };
            setTimeout(() => this.toast.show = false, 3000);
        }
    }"
    @notify.window="showToast($event.detail.message, $event.detail.type)"
    class="min-h-screen bg-gradient-to-br from-violet-50 to-indigo-100 flex items-start justify-center pt-16 px-4"
>
    {{-- Toast Notification --}}
    <div
        x-show="toast.show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        :class="toast.type === 'success' ? 'bg-green-500' : 'bg-red-500'"
        class="fixed bottom-6 right-6 text-white text-sm font-medium px-5 py-3 rounded-2xl shadow-lg z-50"
        x-cloak
    >
        <span x-text="toast.message"></span>
    </div>

    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-indigo-700 tracking-tight">My Todos</h1>
            <p class="text-indigo-400 mt-1 text-sm">
                {{ auth()->user()->todos()->where('completed', false)->count() }} tasks remaining
            </p>
        </div>

        {{-- Add Task Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 p-4 mb-4 flex flex-col gap-2">
            <div class="flex gap-2">
                <input
                    type="text"
                    wire:model="task"
                    wire:keydown.enter="addTodo"
                    placeholder="Add a new task..."
                    class="flex-1 outline-none text-gray-700 placeholder-gray-300 text-sm"
                >
                <button
                    wire:click="addTodo"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition"
                >
                    Add
                </button>
            </div>
            <input
                type="datetime-local"
                wire:model="dueAt"
                class="text-xs text-gray-400 outline-none border-t border-gray-100 pt-2"
            >
        </div>

        {{-- Filters --}}
        <div class="flex gap-2 mb-4">
            @foreach (['all' => 'All', 'pending' => 'Pending', 'completed' => 'Completed'] as $value => $label)
                <button
                    wire:click="setFilter('{{ $value }}')"
                    class="text-xs px-4 py-1.5 rounded-full border transition
                        {{ $filter === $value
                            ? 'bg-indigo-600 text-white border-indigo-600'
                            : 'bg-white text-gray-400 border-gray-200 hover:border-indigo-300' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @error('task')
            <p class="text-red-400 text-xs mb-3 px-1">{{ $message }}</p>
        @enderror

        {{-- Todo List --}}
        <div class="space-y-2">
            @forelse (auth()->user()->todos()->latest()
                ->when($filter === 'completed', fn($q) => $q->where('completed', true))
                ->when($filter === 'pending', fn($q) => $q->where('completed', false))
                ->get() as $todo)
                <div class="bg-white rounded-2xl shadow-sm border border-indigo-50 px-4 py-3 flex items-center gap-3 group">

                    {{-- Avatar --}}
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold text-xs shrink-0">
                        {{ strtoupper(substr($todo->title, 0, 1)) }}
                    </div>

                    {{-- Title --}}
                    <div class="flex-1 cursor-pointer select-none" wire:click="toggle({{ $todo->id }})">
                        <span class="text-sm {{ $todo->completed ? 'line-through text-gray-300' : 'text-gray-700' }}">
                            {{ $todo->title }}
                        </span>
                        @if($todo->due_at)
                            <div class="text-xs text-gray-400">
                                Due {{ $todo->due_at->format('M j, g:i A') }}
                            </div>
                        @endif
                    </div>

                    {{-- Status badge --}}
                    @if($todo->completed)
                        <span class="text-xs bg-green-100 text-green-500 px-2 py-0.5 rounded-full">Done</span>
                    @else
                        <span class="text-xs bg-yellow-100 text-yellow-500 px-2 py-0.5 rounded-full">Pending</span>
                    @endif

                    {{-- Delete --}}
                    <button
                        wire:click="delete({{ $todo->id }})"
                        class="text-gray-200 hover:text-red-400 transition text-lg leading-none opacity-0 group-hover:opacity-100"
                    >
                        &times;
                    </button>

                </div>
            @empty
                <div class="text-center text-gray-300 py-12 text-sm">
                    No tasks yet — add one above!
                </div>
            @endforelse
        </div>

    </div>
</div>