<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\TaskRequest;

class TaskController extends Controller
{
    public function index()
    {

        $tasks = Task::orderBy('created_at', 'desc')->get();

        $pendingTasks = $tasks->where('is_completed', false);

        $completedTasks = $tasks->where('is_completed', true);

        return view('tasks.index', compact('pendingTasks', 'completedTasks'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa craida com sucesso.');
    }

    public function toggle(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return redirect()->route('tasks.index')
            ->with('success', 'Status da tarefa atualizado com sucesso.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa excluída com sucesso.');
    }
}
