<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
       

        $user = Auth::user();

        $request->validate([
            'title' => 'required|max:255', 
            'description' => 'nullable',
            'status' => 'nullable|in:Não Iniciado,Em Andamento,Concluído',
        ]);

        $task = new Task;
        $task->title = $request->input('title');
        $task->description = $request->input('description');

        if ($request->has('status')) {
            $task->status = $request->input('status');
        }

        $user->tasks()->save($task);

        return redirect()->route('main')->with('success', 'Tarefa adicionada com sucesso!');
    }


    

    public function updateStatus(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->status = $request->input('status');
        $task->save();

        return response()->json(['message' => 'Status atualizado com sucesso']);
    }



    public function destroy(int $id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->delete();

        return redirect()->route('main')->with('success', 'Tarefa excluída com sucesso.');
    }
}
