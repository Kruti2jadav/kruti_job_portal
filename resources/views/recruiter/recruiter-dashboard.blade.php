<x-layout_recruiter> 
<x-slot name="content">
    @php
    if (!session()->has('user')) {
        header('Location: /'); // redirect to home
        exit;
    }
@endphp
<div class="container mt-5">
    <h2 class="mb-4">Welcome, {{ session('user.name') }} (Recruiter)</h2> 
    @if(session('success'))
        <div class="alert alert-success" id="flash-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="flash-message">
            {{ session('error') }}
        </div>
    @endif 
    <script> 
        setTimeout(function(){
            let flash = document.getElementById('flash-message');
            if(flash){ 
                setTimeout(() => flash.remove(), 500);
            }
        }, 2000);
    </script> 
    {{-- Action Buttons --}}
    <div class="mb-4">
        <a href="{{ url('/recruiter/job/create') }}" class="btn btn-primary">Post New Job</a> 
    </div> 
    {{-- Application Table --}}
    <div class="card">
        <div class="card-header">
           <h4 class="mt-5">Recent Applications</h4>
        </div>
        <div class="card-body p-5">
<table class="table table-bordered">
   <thead class="table-dark">
<tr>
    <th>Candidate</th>
    <th>Job</th>
    <th>Stage</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($applications as $app)
<tr>
    <td>{{ $app->candidate_name }}</td>
    <td>{{ $app->job_title }}</td>
    <td>
        <span class="badge bg-info">{{ $app->stage }}</span>
    </td>
    <td>
        <a href="{{ url('/recruiter/application/'.$app->id) }}"
           class="btn btn-sm btn-outline-primary">
            See More
        </a>
    </td>
</tr>
@endforeach
</tbody>
</table>
        </div>
    </div>
</div>
</x-slot>
</x-layout>
