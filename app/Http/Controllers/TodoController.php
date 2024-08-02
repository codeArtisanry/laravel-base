<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
  // Function to get all todos
  public function index(Request $request)
  {
    $query = Todo::query();

    if ($request->has('status')) {
      $query->where('status', $request->status);
    }

    if ($request->has('search')) {
      $query->where('title', 'like', '%' . $request->search . '%');
    }

    return response()->json($query->get(), 200);
  }

  // Function to store a new todo
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'date' => 'required|date',
      'status' => 'required|in:pending,in_progress,in_review,completed',
    ]);

    $todo = Todo::create($validatedData);

    return response()->json($todo, 201);
  }

  // Function to show a specific todo
  public function show(Todo $todo)
  {
    return response()->json($todo, 200);
  }

  // Function to update a specific todo
  public function update(Request $request, Todo $todo)
  {
    $validatedData = $request->validate([
      'title' => 'string|max:255',
      'description' => 'nullable|string',
      'date' => 'date',
      'status' => 'in:pending,in_progress,in_review,completed',
    ]);

    $todo->update($validatedData);

    return response()->json($todo, 200);
  }

  // Function to delete a specific todo
  public function destroy(Todo $todo)
  {
    $todo->delete();

    return response()->json(null, 204);
  }
}
