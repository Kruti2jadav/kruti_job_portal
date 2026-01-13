<x-layout_candidate>
<x-slot name="content">

<div class="container mt-5">
    <h3 class="mb-4">HR Reviewer – Communication Evaluation</h3>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="flash-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <script>
        setTimeout(() => {
            let flash = document.getElementById('flash-message');
            if (flash) flash.remove();
        }, 2000);
    </script>

    @forelse($applications as $app)
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="row">
                    {{-- LEFT: Candidate Details --}}
                    <div class="col-md-7 border-end">
                        <h5 class="mb-3">{{ $app->candidate->name }}</h5>

                        <p><strong>Job:</strong> {{ $app->job->title }}</p>

                        <div class="mb-2">
                            <span class="badge bg-primary">
                                Resume: {{ round($app->resume_score,2) }}%
                            </span>
                            <span class="badge bg-dark">
                                GitHub: {{ $app->github_score }}%
                            </span>
                            <span class="badge bg-success">
                                Tech: {{ $app->tech_score ?? 'Pending' }}
                            </span>
                        </div>

                        <p class="mt-2">
                            <strong>Stage:</strong>
                            <span class="text-info">{{ $app->stage }}</span>
                        </p>

                        <p>
                            <strong>Resume:</strong>
                            <a href="{{ asset('resumes/'.$app->candidate->resume) }}" target="_blank">
                                View Resume
                            </a>
                        </p>

                        <p>
                            <strong>GitHub:</strong>
                            <a href="{{ $app->candidate->gitprofile }}" target="_blank">
                                {{ $app->candidate->gitprofile }}
                            </a>
                        </p>
                    </div>

                    {{-- RIGHT: HR Evaluation --}}
                    <div class="col-md-5">
                         <form method="POST" action="{{ url('/review/hr/'.$app->id) }}">
        @csrf

        <h6 class="mb-3">Communication Skills</h6>

        {{-- Row 1 --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Clarity (0–25)</label>
                <input type="number" name="clarity" class="form-control" min="0" max="25" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Confidence (0–25)</label>
                <input type="number" name="confidence" class="form-control" min="0" max="25" required>
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Language (0–25)</label>
                <input type="number" name="language" class="form-control" min="0" max="25" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Attitude (0–25)</label>
                <input type="number" name="attitude" class="form-control" min="0" max="25" required>
            </div>
        </div>

        {{-- Row 3 --}}
      <div class="row align-items-end">
    <div class="col-md-8">
        <label class="form-label">HR Comment</label>
        <textarea name="hr_comment" class="form-control" rows="2"></textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label invisible">Submit</label>
        <button class="btn btn-primary w-100">
            Submit  
        </button>
    </div>
</div>

    </form>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center text-muted mt-4">
            No candidates pending for HR review.
        </div>
    @endforelse
</div>

</x-slot>
</x-layout_candidate>
