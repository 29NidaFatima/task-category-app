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
        $query = Task::where('user_id', Auth::id())
            ->with('category');

        // Sorting
        $sort = request('sort', 'latest');

        if ($sort === 'due_date') {
            $query->orderByRaw('due_date IS NULL, due_date ASC');
        } elseif ($sort === 'priority') {
            $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
        } else {
            $query->latest();
        }

        $tasks = $query->get();

        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }


    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'pending',
            'priority' => $request->priority,
            'due_date' => $request->due_date,
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

    // UPDATE
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:pending,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $status = $request->status ?? $task->status;

        $task->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'category_id'  => $request->category_id,
            'status'       => $status,
            'priority'     => $request->priority,
            'due_date'     => $request->due_date,
            'completed_at' => $status === 'completed' ? now() : null,
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
