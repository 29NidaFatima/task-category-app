<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // =========================
    // READ ACTIVE TASKS
    // =========================
    public function index()
    {
        $query = Task::where('user_id', Auth::id())
            ->whereNull('archived_at')
            ->with('category', 'tags');


        if (request()->filled('tag_id')) {
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', request('tag_id'));
            });
        }

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
        $tags = Tag::all();

        return view('tasks.index', compact('tasks', 'categories', 'tags'));
    }


    // =========================
    // READ ARCHIVED TASKS
    // =========================
    public function archived()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->whereNotNull('archived_at')
            ->with(['category', 'tags'])
            ->latest()
            ->get();

        return view('tasks.archived', compact('tasks'));
    }

    // =========================
    // CREATE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'tags'        => 'array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $task = Task::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'pending',
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
        ]);


        $task->tags()->sync($request->tags ?? []);

        return redirect('/tasks');
    }

    // =========================
    // EDIT PAGE
    // =========================
    public function edit(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $categories = Category::all();
        $tags = Tag::all();
        $selectedTags = $task->tags->pluck('id')->toArray();

        return view('tasks.edit', compact('task', 'categories', 'tags', 'selectedTags'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $request->validate([
            'title'       => 'required',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'nullable|in:pending,completed',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'tags'        => 'array',
            'tags.*'      => 'exists:tags,id',
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


        $task->tags()->sync($request->tags ?? []);

        return redirect('/tasks');
    }

    // =========================
    // ARCHIVE TASK
    // =========================
    public function archive(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $task->update(['archived_at' => now()]);

        return redirect()->route('tasks.archived');
    }

    // =========================
    // UNARCHIVE TASK
    // =========================
    public function unarchive(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $task->update(['archived_at' => null]);

        return redirect('/tasks');
    }

    // =========================
    // DELETE (SOFT DELETE)
    // =========================
    public function destroy(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $task->delete();

        return redirect('/tasks');
    }
}
