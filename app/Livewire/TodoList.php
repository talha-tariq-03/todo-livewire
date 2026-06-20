<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Livewire\Attributes\Validate;
use App\Jobs\SendTaskAddedEmail;

class TodoList extends Component
{
    #[Validate('required|min:3')]
    public string $task = '';
    public string $filter = 'all';
    public string $dueAt = '';


    
    public function addTodo()
    {
            $this->validate();
        $todo = auth()->user()->todos()->create([
            'title' => $this->task,
            'due_at' => $this->dueAt ?: null,
        ]);
        $this->task = '';
        $this->dueAt = '';

        SendTaskAddedEmail::dispatch($todo, auth()->user()->email);

        $this->dispatch('notify', message: 'Task added!', type: 'success');
    }

    public function toggle($id)
    {
        $todo = auth()->user()->todos()->findOrFail($id);
        $todo->update(['completed' => !$todo->completed]);
        $this->dispatch('notify',
            message: $todo->completed ? 'Task completed!' : 'Task reopened!',
            type: 'success'
        );
    }

    public function delete($id)
    {
        auth()->user()->todos()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Task deleted!', type: 'error');
    }

    public function setFilter($value)
    {
        $this->filter = $value;
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}