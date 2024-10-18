<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

//index
Route::get('/', function () {
    $jobs = Job::all();
    return view('home');
});

//about
Route::get('/about', function () {
    return view('about');
});

//jobs
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

//create jobs
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

//show jobs
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);
});

//store
Route::post('/jobs', function () {
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
});

//Edit
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);
    return view('jobs.edit', ['job' => $job]);
});

//Update
Route::patch('/jobs/{id}', function ($id) {
    //Validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);
    //Authorize(On hold...)

    //Update
    $job = Job::findOrFail($id);

    //And presist
    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);

    //Redirect
    return redirect('/jobs/' . $job->id);
});

//Destroy
Route::delete('/jobs/{id}', function ($id) {
    //Authorize(On hold...)

    //Delete 
    $job = Job::findOrFail($id);
    $job->delete();

    //Redirect
    return redirect('/jobs');
});


Route::get('/contact', function () {
    return view('contact');
});

Route::get('/faq', function () {
    return view('faq');
});
