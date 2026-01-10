<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // READ
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->with('category')
            ->get();

        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);

        Task::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        return redirect('/tasks');
    }

    // EDIT PAGE
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();

        return view('tasks.edit', compact('task', 'categories'));
    }

    // UPDATE (edit + status toggle)
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'status' => 'nullable|in:pending,completed',
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status'      => $request->status ?? $task->status,
        ]);

        return redirect('/tasks');
    }

    // DELETE
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return redirect('/tasks');
    }
}
