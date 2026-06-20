<div class="min-h-screen bg-gradient-to-br from-violet-50 to-indigo-100 px-4 pt-16">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-indigo-700 tracking-tight">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p class="text-indigo-400 mt-1 text-sm">Here's where things stand</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-indigo-50 p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $totalTasks }}</div>
                <div class="text-xs text-gray-400 mt-1">Total</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-indigo-50 p-4 text-center">
                <div class="text-2xl font-bold text-yellow-500">{{ $pendingTasks }}</div>
                <div class="text-xs text-gray-400 mt-1">Pending</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-indigo-50 p-4 text-center">
                <div class="text-2xl font-bold text-green-500">{{ $completedTasks }}</div>
                <div class="text-xs text-gray-400 mt-1">Completed</div>
            </div>
        </div>

        {{-- Upcoming Tasks --}}
        @if($upcomingTasks->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-indigo-50 p-4 mb-6">
                <h2 class="text-sm font-semibold text-gray-500 mb-3">Coming up</h2>
                <div class="space-y-2">
                    @foreach($upcomingTasks as $task)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ $task->title }}</span>
                            <span class="text-xs text-gray-400">{{ $task->due_at->format('M j, g:i A') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA --}}
        
            href="{{ route('todos') }}"
            class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-xl transition"
        >
            View All Todos
        </a>

    </div>
</div>