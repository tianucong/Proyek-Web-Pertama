<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoController extends Controller
{
     public function index(Request $request)
    {
        $lists = $request->user()->todoLists()->with('tasks')->get();

        return $lists->map(fn ($list) => [
            'id'    => $list->id,
            'nama'  => $list->nama,
            'tugas' => $list->tasks->map(fn ($task) => $this->formatTask($task))->values(),
        ]);
    }


    public function storeList(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:20',
        ]);

        $list = $request->user()->todoLists()->create($data);

        return ['id' => $list->id, 'nama' => $list->nama, 'tugas' => []];
    }

    public function storeTask(Request $request, TodoList $list)
    {
        abort_if($list->user_id !== $request->user()->id, 403);

        $data = $request->validate([
            'teks'  => 'required|string|max:255',
            'waktu' => 'nullable|string|max:50',
        ]);

        $task = $list->tasks()->create($data);
        $task->refresh();

        return $this->formatTask($task);
    }

     public function updateTask(Request $request, Task $task)
    {
        abort_if($task->todoList->user_id !== $request->user()->id, 403);

        $data = $request->validate([
            'selesai' => 'required|boolean',
        ]);

        $task->update($data);

        return $this->formatTask($task);
    }

     public function destroyTask(Request $request, Task $task)
    {
        abort_if($task->todoList->user_id !== $request->user()->id, 403);

        $task->delete();

        return response()->noContent();
    }

    private function formatTask(Task $task)
    {
        return [
            'id'      => $task->id,
            'teks'    => $task->teks,
            'waktu'   => $task->waktu,
            'selesai' => $task->selesai,
        ];
    }
}