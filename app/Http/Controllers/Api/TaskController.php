<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function getAll(Request $request){
        if($request->has('status')){
            $tasks = Task::where('user_id', $request->user()->id)->where('status', $request->status)->get();
        }else{
            $tasks = Task::where('user_id', $request->user()->id)->get();
        }
        return $tasks;
    }

    public function post(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'titulo' => 'required|string|max:255',
                'descricao' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ],
            [
                'title.required' => 'Title obrigatório',
                'description.required' => 'Description obrigatório',
                'status.required' => 'Status obrigatório',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $task = new Task();
        $task->titulo = $request->titulo;
        $task->descricao = $request->descricao;
        $task->status = $request->status;
        $task->user_id = $request->user()->id;
        $task->save();
        return $task;
    }

    public function put(Request $request, string $id){
        $validator = Validator::make(
            $request->all(),
            [
                'titulo' => 'required|string|max:255',
                'descricao' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ],
            [
                'titulo.required' => 'Titulo obrigatório',
                'description.required' => 'Description obrigatório',
                'status.required' => 'Status obrigatório',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $task = Task::find($id);
        $task->titulo = $request->titulo;
        $task->descricao = $request->descricao;
        $task->status = $request->status;
        $task->updated_at = now();
        $task->save();
        return $task;
    }

    public function delete(string $id){
        $task = Task::find($id);
        $task->delete();
        return $task;
    }
}
