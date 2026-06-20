<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.dashboard', [
            'totalTasks' => $user->todos()->count(),
            'pendingTasks' => $user->todos()->where('completed', false)->count(),
            'completedTasks' => $user->todos()->where('completed', true)->count(),
            'upcomingTasks' => $user->todos()
                ->where('completed', false)
                ->whereNotNull('due_at')
                ->where('due_at', '>=', now())
                ->orderBy('due_at')
                ->take(3)
                ->get(),
        ]);
    }
}