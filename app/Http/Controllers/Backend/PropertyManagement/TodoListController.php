<?php

namespace App\Http\Controllers\Backend\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index()
    {
        $todos = TodoList::latest()->paginate(15);
        return view('backend.property-management.todo-list.index', compact('todos'));
    }

    public function create()
    {
        return redirect()->route('todo-list.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'due_date' => 'nullable|date',
            'type'     => 'required|in:Appointment,To-Do',
            'status'   => 'required|in:Open,Done,Postponed',
        ]);

        $data = $request->all();
        $data['entry_date'] = now();

        TodoList::create($data);

        return redirect()->route('todo-list.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(TodoList $todoList)
    {
        return redirect()->route('todo-list.index');
    }

    public function update(Request $request, TodoList $todoList)
    {
        $request->validate([
            'due_date' => 'nullable|date',
            'type'     => 'required|in:Appointment,To-Do',
            'status'   => 'required|in:Open,Done,Postponed',
        ]);

        $todoList->update($request->all());

        return redirect()->route('todo-list.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete();
        return redirect()->route('todo-list.index')
            ->with('success', 'Task deleted successfully.');
    }
}
