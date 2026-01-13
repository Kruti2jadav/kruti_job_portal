 <x-layout_recruiter>
<x-slot name="content">

<div class="container mt-4">

<h3 class="mb-4">Application Details</h3>

<div class="card shadow-sm">
<div class="card-body">

<h5>{{ $application->candidate->name }}</h5>
<p><strong>Job:</strong> {{ $application->job->title }}</p>

<hr>

<div class="row mb-3">
    <div class="col-md-6">
        <p><strong>Skills:</strong> {{ $application->skills }}</p>
        <p>
            <strong>Resume:</strong>
            <a href="{{ asset($application->resume) }}" target="_blank">
                View Resume
            </a>
        </p>
        <p>
            <strong>GitHub:</strong>
            <a href="{{ $application->candidate->gitprofile }}" target="_blank">
                {{ $application->candidate->gitprofile }}
            </a>
        </p>
    </div>

    <div class="col-md-6">
        <p><strong>Resume Score:</strong> {{ $application->resume_score }}%</p>
        <p><strong>GitHub Score:</strong> {{ $application->github_score }}%</p>
        <p><strong>Tech Score:</strong> {{ $application->tech_score }}</p>
        <p><strong>Communication Score:</strong> {{ $application->comm_score }}</p>
        <p class="fw-bold text-success">
            Total Score: {{ $totalScore }}
        </p>
    </div>
</div>

<hr>

<h6>Reviewer Comments</h6>
<p><strong>Tech Reviewer:</strong> {{ $application->tech_comment ?? '—' }}</p>
<p><strong>HR Reviewer:</strong> {{ $application->hr_comment ?? '—' }}</p>

<hr>

@if($application->stage !== 'Selected')
<form method="POST" action="{{ url('/recruiter/application/'.$application->id.'/select') }}">
    @csrf
    <button class="btn btn-success">
        Select Candidate
    </button>
</form>
@else
<span class="badge bg-success">Candidate Selected</span>
@endif

</div>
</div>

</div>

</x-slot>
</x-layout_recruiter>
