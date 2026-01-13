<x-layout_candidate>
<x-slot name="content">

<div class="container mt-5">
    <h3>Available Jobs</h3>

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

    @foreach($jobs as $job)
    <div class="card mb-3">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">
                {{-- Job Details --}}
                <div>
                    <h5>{{ $job->title }}</h5>
                    <p class="mb-1">{{ $job->description }}</p>
                    <p class="mb-0">
                        <strong>Skills Required:</strong> {{ $job->skills }}
                    </p>
                </div>

                {{-- Apply Button --}}
                <div class="text-end">
                    @if(in_array($job->id, $appliedJobs))
                        <span class="badge bg-success">Already Applied</span>
                    @else
                        <a href="{{ url('/apply-job/'.$job->id) }}" class="btn btn-primary">
                            Apply
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>

</x-slot>
</x-layout_candidate>
