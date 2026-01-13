<x-layout_candidate>
<x-slot name="content">

@php
    if (!session()->has('user') || session('user')['role'] !== 'candidate') {
        header('Location: /');
        exit;
    }
@endphp

<div class="container mt-5" style="max-width: 600px;">
    <h3>Candidate Profile</h3>

    {{-- Flash messages --}}
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

    <form action="{{ url('/candidate/profileupdate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            @error('name')<span class="text-danger">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label>Skills (comma separated)</label>
            <input type="text" name="skills" class="form-control" value="{{ $user->skills }}">
             @error('skills')<span class="text-danger">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label>Resume</label>
            <input type="file" name="resume" class="form-control">
            @error('resume')<span class="text-danger">{{$message}}</span>@enderror
            @if($user->resume)
                <small>Current: <a href="{{ asset($user->resume) }}" target="_blank">View Resume</a></small>
            @endif
        </div>
        <div class="mb-3">
            <label>GitHub Profile URL</label>
            <input type="text" name="gitprofile" class="form-control" value="{{ $user->gitprofile ?? '' }}" placeholder="https://github.com/username"> 
        </div>
        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>
</div>

</x-slot>
</x-layout_candidate>
