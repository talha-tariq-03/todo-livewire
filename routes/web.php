<?php

use Illuminate\Support\Facades\Route;
use App\Models\Todo;
use Illuminate\Http\Request;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', App\Livewire\Dashboard::class)->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
    Route::get('/todos', function () {
        return view('todo-page');
    })->name('todos');
});

Route::get('/todos/{todo}/complete', function (Todo $todo) {
    abort_unless(request()->hasValidSignature(), 403);

    $todo->update(['completed' => true]);

    return redirect()->route('login')->with('status', 'Task marked as complete! Please log in to view your todos.');
})->name('todos.complete');

require __DIR__.'/auth.php';