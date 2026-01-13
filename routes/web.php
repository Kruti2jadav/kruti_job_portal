<?php
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginForm']);
Route::get('/login', [AuthController::class, 'loginForm']); 
Route::get('/register-form', function(){
    return view('auth.register');
});
Route::view('/recruiter-dashboard','recruiter.recruiter-dashboard');
Route::get('/recruiter/job/create', [RecruiterController::class, 'createJob']);
Route::get('/candidate/profile', [CandidateController::class, 'profile']);
Route::post('/candidate/profileupdate', [CandidateController::class, 'updateProfile']);
Route::get('/apply-job/{jobId}', [CandidateController::class, 'applyJob']);
Route::post('/recruiter/job/store', [RecruiterController::class, 'storeJob']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/view-jobs', [CandidateController::class, 'viewJobs']);
Route::get('/recruiter-dashboard', [RecruiterController::class, 'dashboard']);
Route::get('/tech-reviewer', [ReviewerController::class, 'techReviewerPage']);
Route::post('/tech-reviewer/review/{id}', [ReviewerController::class, 'submitTechReview']);
Route::get('/hr-reviewer', [ReviewerController::class, 'hrDashboard']);
Route::post('/review/hr/{id}', [ReviewerController::class, 'hrReview']);  
Route::get('/recruiter/application/{id}', [RecruiterController::class, 'viewApplication']);
Route::post('/recruiter/application/{id}/select', [RecruiterController::class, 'selectCandidate']);
Route::get('/leaderboard', [LeaderboardController::class, 'index']);


