<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

/**
 * Class TaskController
 *
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * @var Task
     */
    private $task;

    /**
     * TaskController constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->middleware('auth');

        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'tasks' => $this->task->list([
                'user_id'   => auth()->user()->id
            ])
        ]);
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
     * @param TaskRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = $this->task->create([
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'user_id'     => auth()->user()->id
        ]);

        return response()->json([
            'task'    => $task,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request)
    {
        $this
            ->task
            ->find($request->task)
            ->update([
                'name'  => $request->get('name'),
                'description'   => $request->get('description')
            ]);

        return response(null, 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $this
            ->task
            ->find(request()->task)
            ->delete();

        return response(null, 205);
    }
}
