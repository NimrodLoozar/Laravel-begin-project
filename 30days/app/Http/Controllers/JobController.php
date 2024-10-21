<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function jobs_view()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }
    public function create()
    {
        return view('jobs.create');
    }
    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }
    public function store()
    {
        //Validation
        // dd('helo form the post request');
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        return redirect('/jobs');
    }
    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }
    public function update(Job $job)
    {
        //Validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);
        //Authorize(On hold...)

        //Update
        // $job = Job::findOrFail($id);

        //And presist
        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        //Redirect
        return redirect('/jobs/' . $job->id);
    }
    public function destroy(Job $job)
    { //Authorize(On hold...)

        //Delete 
        // $job = Job::findOrFail($id);
        $job->delete();

        //Redirect
        return redirect('/jobs');
    }
}
