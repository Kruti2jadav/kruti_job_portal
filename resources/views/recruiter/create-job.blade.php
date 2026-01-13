<x-layout_recruiter>
<x-slot name="content">
@php
    if (!session()->has('user') || session('user')['role'] !== 'recruiter') {
        header('Location: /');
        exit;
    }
@endphp
<div class="container mt-5" style="max-width: 600px;">
    <h3>Post a New Job</h3> 
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif 
    <form action="{{ url('/recruiter/job/store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Job Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Skills</label>
            <input type="text" name="skills" class="form-control" value="{{ old('skills') }}">
            @error('skills') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn btn-success">Post Job</button>
        <a href="{{ url('/recruiter-dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div> 
</x-slot>
</x-layout_recruiter>
