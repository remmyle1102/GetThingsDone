<?php

namespace App\Http\Controllers;

use App\task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(task::latest()->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'required',
            'finished' => 'required|boolean',
        ]);

        $task = task::create($data);
        return response($task, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\task $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        return response($task, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, task $task)
    {
        $data = $request->validate([
            'text' => 'required',
            'finished' => 'required|boolean',
        ]);
        $task->update($data);
        return response($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(task $task)
    {
        $task->delete();
        return response('Delete Successfully', 200);
    }
}
