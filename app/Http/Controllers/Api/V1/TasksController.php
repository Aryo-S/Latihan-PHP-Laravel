<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TasksController extends Controller
{
    public function index()
    {   
        // TaskResources::collection() datang dari Resources -> taskResources akan membatasi data yang kembali
        $tasks = TaskResource::collection(Task::all());
        return response()->json([
            'tasks' => $tasks,
        ], Response::HTTP_OK);
    }

    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    public function store(StoreTaskRequest $request)
    {
        // membuat data entry baru sesuai request 
        $task = Task::create($request->validated());
        return TaskResource::make($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {   
        try {
            $validatedData = $request->validated();
            $task->update($validatedData);
            return response()->json(['message' => "successfully updated", "task" => $task->name], 201);
        } 
        catch (ValidationException $e) {
            return response()->json(
                [
                    'message' => 'Validation error', 
                    'errors' => $e->errors()
                ], 
            422);
        }
        catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to update task', 
                    'error' => $e->getMessage()
                ], 
            500);
        }
        // $task->update($request->validated());
        // return TaskResource::make($task);
    }

    public function destroy(Task $task) 
    {
        $task -> delete();
        return response()->noContent();
    }
}