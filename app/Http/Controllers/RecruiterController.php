<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    public function createJob()
    { 
        if (!session()->has('user') || session('user')['role'] !== 'recruiter') {
            return redirect('/')->with('error', 'Access denied!');
        } 
        return view('recruiter.create-job');
    }
     public function storeJob(Request $request)
    { 
        $request->validate([
            'title' => 'required|string|max:100',
            'skills' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]); 
        Job::create([
            'recruiter_id' => session('user')['id'],  
            'title' => $request->title,
            'skills' => $request->skills,
            'description' => $request->description,
        ]);
        return redirect('/recruiter-dashboard')->with('success', 'Job posted successfully!');
    }

    public function dashboard()
{
    if (!session()->has('user') || session('user')['role'] !== 'recruiter') {
        return redirect('/')->with('error', 'Access denied!');
    }
    $recruiterId = session('user')['id']; 
    $jobs = Job::where('recruiter_id', $recruiterId)
               ->orderBy('created_at', 'desc')
               ->get(); 
    $applications = JobApplication::join('jobs', 'job_applications.job_id', '=', 'jobs.id')
        ->join('users', 'job_applications.candidate_id', '=', 'users.id')
        ->where('jobs.recruiter_id', $recruiterId)
        ->select(
            'job_applications.*',
            'jobs.title as job_title',
            'users.name as candidate_name',
            'users.email'
        )
        ->orderBy('job_applications.applied_at', 'desc')
        ->get();
//dd($applications);

    return view('recruiter.recruiter-dashboard', [
        'applications' => $applications
    ]);
}
//
public function viewApplication($id)
{
    if (session('user')['role'] !== 'recruiter') {
       return redirect('/')->with('error', 'Access denied!');
    }

    $application = JobApplication::with(['candidate', 'job'])->findOrFail($id);

    $totalScore =
        ($application->resume_score ?? 0) +
        ($application->github_score ?? 0) +
        ($application->tech_score ?? 0) +
        ($application->comm_score ?? 0);

    return view('recruiter.application-detail', compact('application', 'totalScore'));
}

public function selectCandidate($id)
{
    if (session('user')['role'] !== 'recruiter') {
        return redirect('/')->with('error', 'Access denied!');
    }

    $application = JobApplication::findOrFail($id);
    $application->stage = 'Selected';
    $application->save();

    return back()->with('success', 'Candidate selected successfully');
}

}
