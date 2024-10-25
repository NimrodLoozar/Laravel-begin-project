<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function index()
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

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        Mail::to($job->employer->user)->queue(
            new JobPosted($job)
        );

        return redirect('/jobs');
    }
    public function edit(Job $job)
    {
        Gate::authorize('edit', $job);

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
