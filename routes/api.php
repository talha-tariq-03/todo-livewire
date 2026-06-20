<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Todo;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/todos', function (Request $request) {
        return $request->user()->todos()->latest()->get();
    });

    Route::post('/todos', function (Request $request) {
        $request->validate(['title' => 'required|min:3']);
        $todo = $request->user()->todos()->create([
            'title' => $request->title
        ]);
        return response()->json($todo, 201);
    });

    Route::patch('/todos/{id}', function (Request $request, $id) {
        $todo = $request->user()->todos()->findOrFail($id);
        $todo->update(['completed' => !$todo->completed]);
        return response()->json($todo);
    });

    Route::delete('/todos/{id}', function (Request $request, $id) {
        $request->user()->todos()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    });

});