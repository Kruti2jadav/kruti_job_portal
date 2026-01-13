<?php

namespace App\Http\Controllers;
use Smalot\PdfParser\Parser;
use GuzzleHttp\Client;
use App\Models\Job;
use App\Models\Users;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function profile()
    {
        if (!session()->has('user') || session('user')['role'] !== 'candidate') {
            return redirect('/')->with('error', 'Access denied!');
        } 
        $user = Users::find(session('user')['id']);
        return view('candidate.profile', compact('user'));
    } 
  public function updateProfile(Request $request)
{
    //dd($request->all()); 
    if (!session()->has('user') || session('user')['role'] !== 'candidate') {
        return redirect('/')->with('error', 'Access denied!');
    }
    $user = Users::find(session('user')['id']);
    $request->validate([
        'name'   => 'required|string|max:100',
        'skills' => 'nullable|string|max:255',
        'resume' => 'nullable|mimes:pdf,doc,docx|max:10240',
    ]);
    $user->name   = $request->name;
    $user->skills = $request->skills;
    if ($request->hasFile('resume')) {
        $file = $request->file('resume');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('resumes'), $filename);
        $user->resume =  $filename;
    }
    $user->gitprofile = $request->gitprofile;
    $user->save();
    session(['user' => [
        'id'     => $user->id,
        'name'   => $user->name,
        'role'   => $user->role,
        'email'  => $user->email,
        'skills' => $user->skills ?? '',
        'resume' => $user->resume ?? '',
        'gitprofile' => $user->gitprofile ?? ''
    ]]);
    return redirect()->back()->with('success', 'Profile updated successfully!');
}
/*public function applyJob(Request $request, $jobId)
{
    // Auth check
    if (!session()->has('user') || session('user')['role'] !== 'candidate') {
        return redirect('/')->with('error', 'Access denied!');
    }
    $candidateId = session('user')['id'];
    $user = Users::find($candidateId); 
    if (empty($user->skills) || empty($user->resume)) {
        return redirect('/candidate/profile')
            ->with('error', 'Please complete your profile (add skills and resume) before applying for jobs.');
    } 
    if (JobApplication::where('candidate_id', $candidateId)
        ->where('job_id', $jobId)
        ->exists()) {
        return redirect()->back()->with('error', 'You have already applied for this job.');
    }
    JobApplication::create([
        'job_id'       => $jobId,
        'candidate_id' => $candidateId,
        'resume'       => $user->resume,
        'skills'       => $user->skills,
        'stage'        => 'Applied',
    ]);
    return redirect()->back()->with('success', 'Applied successfully!');
}*/ 
public function applyJob(Request $request, $jobId)
{
    // Auth check
    if (!session()->has('user') || session('user')['role'] !== 'candidate') {
        return redirect('/')->with('error', 'Access denied!');
    }

    $candidateId = session('user')['id'];
    $user = Users::find($candidateId);

    // Ensure resume and skills are present
    if (empty($user->skills) || empty($user->resume)) {
        return redirect('/candidate/profile')
            ->with('error', 'Please complete your profile (add skills and resume) before applying for jobs.');
    }

    // Check if already applied
    if (JobApplication::where('candidate_id', $candidateId)
        ->where('job_id', $jobId)
        ->exists()) {
        return redirect()->back()->with('error', 'You have already applied for this job.');
    }

    // Extract Resume Skills
    $resumeScore = 0;
    $requiredSkills = ['PHP','Laravel','JavaScript','React','css','bootstrap','Python']; // job skill map

    $resumePath = public_path('resumes/'. $user->resume);

    if (file_exists($resumePath)) {
        $extension = pathinfo($resumePath, PATHINFO_EXTENSION);

        $text = '';

        if ($extension == 'pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile($resumePath);
            $text = strtolower($pdf->getText());
        } elseif (in_array($extension, ['docx', 'doc'])) {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($resumePath);
            $text = '';
            foreach ($phpWord->getSections() as $section) {
                $elements = $section->getElements();
                foreach ($elements as $el) {
                    if (method_exists($el, 'getText')) {
                        $text .= ' ' . strtolower($el->getText());
                    }
                }
            }
        }

        // Match skills
        $matchedSkills = array_filter($requiredSkills, function($skill) use ($text) {
            return str_contains($text, strtolower($skill));
        });
        $resumeScore = count($matchedSkills) / count($requiredSkills) * 100;
    }

    // Fetch GitHub Data
    $githubScore = 0;
    $gitLang = [];
    if (!empty($user->gitprofile)) {
        $username = basename($user->gitprofile); // get username from URL
        $client = new Client([
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json', 
            ]
        ]);

        try {
            $reposResponse = $client->get("https://api.github.com/users/{$username}/repos");
            $repos = json_decode($reposResponse->getBody(), true);

            $totalCommits = 0;

            foreach ($repos as $repo) {
                $repoName = $repo['name'];

                // Languages used
                $langResponse = $client->get($repo['languages_url']);
                $languages = array_keys(json_decode($langResponse->getBody(), true));
                $gitLang = array_merge($gitLang, $languages);

                // Count commits
                $commitsResponse = $client->get("https://api.github.com/repos/{$username}/{$repoName}/commits");
                $commits = count(json_decode($commitsResponse->getBody(), true));
                $totalCommits += $commits;
            }

            $gitLang = array_unique($gitLang);
            $githubScore = min(100, count($repos) * 5 + $totalCommits);  

        } catch (\Exception $e) {
            // GitHub fetch failed, keep score 0
        }
    } 
    $totalScore = ($resumeScore + $githubScore) / 2;  
    $stage = 'Applied';
    if ($totalScore > 50) {
        $stage = 'Shortlisted';
    } 
    JobApplication::create([
        'job_id'       => $jobId,
        'candidate_id' => $candidateId,
        'resume'       => $user->resume,
        'skills'       => $user->skills,
        'stage'        => $stage,
        'resume_score' => $resumeScore,
        'github_score' => $githubScore,
        'score'        => $totalScore,
        'git_lang'     => implode(',', $gitLang),
        'comm_score'   => 0,  
    ]); 
    return redirect()->back()->with('success', 'Applied successfully!');
}

    public function viewJobs()
{
    if (!session()->has('user') || session('user')['role'] !== 'candidate') {
        return redirect('/')->with('error', 'Access denied!');
    } 
    $candidateId = session('user')['id'];
    $jobs = Job::all(); 
    // Check which jobs candidate already applied
    $appliedJobs = JobApplication::where('candidate_id', $candidateId)->pluck('job_id')->toArray(); 
    return view('candidate.view-job', compact('jobs', 'appliedJobs'));
} 
}
