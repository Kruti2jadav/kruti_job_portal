<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // Only recruiter allowed
        if (!session()->has('user') || session('user.role') !== 'recruiter') {
            return redirect('/')->with('error', 'Access denied');
        }

        $skill = $request->skill;

        // Get all unique skills for dropdown
        $allSkills = DB::table('users')
            ->where('role', 'candidate')
            ->whereNotNull('skills')
            ->get();

        $skills = [];
        foreach ($allSkills as $user) {
            $userSkills = explode(',', $user->skills);
            foreach ($userSkills as $s) {
                $s = trim($s);
                if (!in_array($s, $skills)) {
                    $skills[] = $s;
                }
            }
        }

        // Simple leaderboard query with DISTINCT candidate
        $leadersQuery = DB::table('job_applications')
            ->join('users', 'users.id', '=', 'job_applications.candidate_id')
            ->select(
                'users.id',
                'users.name',
                'users.skills',
                DB::raw('MAX(job_applications.resume_score) as resume_score'),
                DB::raw('MAX(job_applications.github_score) as github_score'),
                DB::raw('MAX(job_applications.tech_score) as tech_score'),
                DB::raw('MAX(job_applications.hr_score) as hr_score')
            )
            ->groupBy('users.id', 'users.name', 'users.skills'); // ensures one row per candidate

        if ($skill) {
            $leadersQuery->where('users.skills', 'LIKE', '%' . $skill . '%');
        }

        $leaders = $leadersQuery->get();

        // Calculate total score
        $leaders->transform(function ($leader) {
            $leader->total_score = 
                ($leader->resume_score ?? 0) +
                ($leader->github_score ?? 0) +
                ($leader->tech_score ?? 0) +
                ($leader->hr_score ?? 0);
            return $leader;
        });

        // Sort collection by total_score descending
        $leaders = $leaders->sortByDesc('total_score');

        return view('recruiter.leaderboard', [
            'leaders' => $leaders,
            'skills' => $skills,
            'skill' => $skill
        ]);
    }
}
