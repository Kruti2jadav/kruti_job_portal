<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\Users;
use App\Models\Job;
class ReviewerController extends Controller
{
     public function hrDashboard()
    { 
        if (!session()->has('user') || session('user')['role'] !== 'hrreviewer') {
            return redirect('/')->with('error', 'Access denied!');
        } 
        $applications = JobApplication::with(['candidate', 'job'])
            ->whereIn('stage', ['Technical Checked', 'Shortlisted'])
            ->get(); 
        return view('hr_reviewer.dashboard', compact('applications'));
    }
    public function hrReview(Request $request, $id)
    {
        if (session('user')['role'] !== 'hrreviewer') {
           return redirect('/')->with('error', 'Access denied!');
        }

        $request->validate([
            'clarity'    => 'required|integer|min:0|max:25',
            'confidence' => 'required|integer|min:0|max:25',
            'language'   => 'required|integer|min:0|max:25',
            'attitude'   => 'required|integer|min:0|max:25',
            'hr_comment' => 'nullable|string',
        ]);

        $commScore =
            $request->clarity +
            $request->confidence +
            $request->language +
            $request->attitude;

        $application = JobApplication::findOrFail($id);

        $application->hr_score = $commScore;
        $application->hr_comment = $request->hr_comment;

        if ($commScore >= 50) {
            $application->stage = 'HR Checked';
        }

        $application->save();

        return back()->with('success', 'HR evaluation submitted successfully');
    }
     public function techReviewerPage()
    {
        if (!session()->has('user') || session('user')['role'] !== 'techreviewer') {
            return redirect('/')->with('error', 'Access denied');
        } 
        $applications = JobApplication::with(['candidate', 'job'])
            ->whereNull('tech_score')
            ->get(); 
        return view('tech_reviewer.dashboard', compact('applications'));
    }
     public function submitTechReview(Request $request, $id)
    {
        if (session('user')['role'] !== 'techreviewer') {
            return redirect('/')->with('error', 'Access denied!');
        } 
        $request->validate([
            'tech_score' => 'required|numeric|min:0|max:100',
            'tech_comment' => 'nullable|string|max:255',
        ]); 
        $app = JobApplication::findOrFail($id); 
        $app->tech_score = $request->tech_score;
        $app->tech_comment = $request->tech_comment;
        $app->stage = 'Technical Checked'; 
        $app->save(); 
        return back()->with('success', 'Tech review submitted successfully');
    }
}
