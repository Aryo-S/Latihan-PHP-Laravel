<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use App\http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CompleteTaskController extends Controller
{
    // sempet error pas __invoke karena typo "_invoke" => "__invoke"
    public function __invoke(Request $request, Task $task)
    {
        // Semacem console.log nya PHP laravel tapi ceknya di root\logs\laravel.logs JANGAN LUPA KASIH MESSAGE BIAR TAU DARI MANA.
        Log::info('Incoming request data:', $request->all());

        // try catch untuk situasi berhasil dan gagal.
        // validasi dulu, jika gagal langsung 'throw' kalau bahasa javascriptnya(?)
        // kalau lewat validasi maka update task bagian is_completed dengan hasil is_completed yang telah divalidasi
        // lalu simpan perubahan di model database
        // lalu kirimkan respon ke dari API, atur kembalinya data seperlunya
        
        // bila gagal lempar ke catch dan panggil Illuminate\Validation\ValidationException $e
        // return response dengan Errors $e->errors() dan JANGAN LUPA ERROR CODENYA
        try {
            $validated = $request->validate([
                // 'required|boolean' itu menghitung 0/1 dan true/false sebagai boolean
                'is_completed' => 'required|boolean',
            ]);
            $task->is_completed = $validated['is_completed'];
            $task->save();
            return response()->json([
                'task' => new TaskResource($task),
                'message' => 'task is marked as complete!'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['Errors' => $e->errors()], 422);
        } 
        
        // Basic form
        // $task->is_completed = $request->is_completed;
        // $task->save();
        // return TaskResource::make($task);
    }
}
