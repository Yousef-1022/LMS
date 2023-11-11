<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use Illuminate\Http\Request;
use App\Models\Task;

class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Task $task)
    {
        $this->authorize('solCreateAllow', $task);
        $solExist = auth()->user()->doesASolutionExistForTask($task);
        if ($solExist) {
            return redirect()->route('tasks.show', ['task' => $task->id])->with('info', 'You already have a solution!');
        }
        return view("solutions.create", [
            "task" => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Task $task, Request $request)
    {
        $this->authorize('solCreateAllow', $task);
        $validated = $request->validate([
            'answer' => 'required',
        ]);
        $validated['student_id'] = auth()->user()->id;
        $task->solutions()->create($validated);
        return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Solution submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Solution $solution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solution $solution)
    {
        $this->authorize('update', $solution);
        return view('solutions.edit', [
            'solution' => $solution,
            'task' => $solution->task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solution $solution)
    {
        $this->authorize('update', $solution);
        //$validated = $request->validated();
        $validated = $request->validate([
            'answer' => 'required',
        ]);
        //  Changing the previous solution will cancel the previous evaluation
        $validated['evaluated'] = 0;
        $valiaded['result'] = 0;
        $solution->update($validated);
        return redirect()->route('tasks.show', ['task' => $solution->task])->with('info', 'Solution updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solution $solution)
    {
        $this->authorize('delete', $solution);
        $solution->delete();
        return redirect()->route('tasks.show', ['task' => $solution->task])->with('drop', 'Solution deleted!');
    }

    public function evaluate(Solution $solution)
    {
        $this->authorize('evaluator', $solution);
        if($solution->evaluated) {
            return redirect()->route('tasks.show', ['task' => $solution->task])->with('error', 'Solution already evaluated!');
        }
        return view('solutions.evaluate', [
            'solution' => $solution,
            'task' => $solution->task,
        ]);
    }

    public function score(Request $request, Solution $solution)
    {
        $this->authorize('evaluator', $solution);
        if($solution->evaluated) {
            return redirect()->route('tasks.show', ['task' => $solution->task])->with('error', 'Solution already evaluated!');
        }
        $max = $solution->task->points;
        $validated = $request->validate([
            'result' => 'required|numeric|between:0,' . $max,
        ]);
        $validated['evaluated'] = 1;
        $student_name = auth()->user()->getNameById($solution->student_id);
        $solution->update($validated);
        return redirect()->route('tasks.show', ['task' => $solution->task])->with('success',
            "'".$student_name."'s solution evaluated with ".$validated['result']."/".$max." !");
    }
}
