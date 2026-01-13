<x-layout_re>
<x-slot name="content">

<div class="container mt-5">
    <h3>Tech Reviewer Dashboard</h3>

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
        setTimeout(function() {
            let flash = document.getElementById('flash-message');
            if(flash){ 
                setTimeout(() => flash.remove(), 1000);
            }
        }, 2000);
    </script>  

    @forelse($applications as $app)
        <div class="card mb-3">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">
                    
                    {{-- Candidate + Scores --}}
                    <div>
                        <h5>{{ $app->candidate->name }}</h5>

                        <p class="mb-1">
                            <strong>Job:</strong> {{ $app->job->title }}
                        </p>

                        <p class="mb-1">
                            <strong>Resume Score:</strong> {{ $app->resume_score }}%
                        </p>

                        <p class="mb-1">
                            <strong>GitHub Score:</strong> {{ $app->github_score }}%
                        </p>

                        <p class="mb-1">
                            <strong>Total Score:</strong>
                            {{ round(($app->resume_score + $app->github_score) / 2, 2) }}%
                        </p>

                        <p class="mb-1">
                            <strong>Resume:</strong>
                            <a href="{{ asset('resumes/'.$app->candidate->resume) }}" target="_blank">
                                View
                            </a>
                        </p>

                        <p class="mb-0">
                            <strong>GitHub:</strong>
                            <a href="{{ $app->candidate->gitprofile }}" target="_blank">
                                {{ $app->candidate->gitprofile }}
                            </a>
                        </p>
                    </div>

                    {{-- Tech Review Form --}}
                    <div style="min-width:260px;">
                        <form method="POST" action="{{ url('/tech-reviewer/review/'.$app->id) }}">
                            @csrf 
                            <div class="mb-2">
                                <label class="form-label">Tech Score</label>
                                <input type="number" name="tech_score" class="form-control" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Comment</label>
                                <textarea name="tech_comment" class="form-control" rows="2"></textarea>
                            </div>

                            <button class="btn btn-primary w-100">
                                Submit Review
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    @empty
        <div class="text-center text-muted mt-4">
            No candidates pending for tech review.
        </div>
    @endforelse

</div>

</x-slot>
</x-layout_re>
