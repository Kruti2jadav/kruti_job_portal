<x-layout_recruiter>
<x-slot name="content">

<div class="container mt-5">

<h3 class="mb-4">🏆 Skill Leaderboard</h3>

{{-- Flash --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Filter --}}
<form method="GET" class="row mb-4">
    <div class="col-md-4">
        <select name="skill" class="form-select" onchange="this.form.submit()">
            <option value="">All Skills</option>
            @foreach($skills as $s)
                <option value="{{ $s }}" {{ $skill == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<div class="card shadow-sm">
<div class="card-body p-0">

<table class="table table-bordered mb-0">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Candidate</th>
    <th>Skills</th>
    <th>Resume</th>
    <th>GitHub</th>
    <th>Tech</th>
    <th>Hr</th>
    <th>Total</th>
</tr>
</thead>

<tbody>
@forelse($leaders as $i => $row)
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $row->name }}</td>
    <td>{{ $row->skills }}</td>
    <td>{{ $row->resume_score ?? 0 }}</td>
    <td>{{ $row->github_score ?? 0 }}</td>
    <td>{{ $row->tech_score ?? 0 }}</td>
    <td>{{ $row->hr_score ?? 0 }}</td>
    <td class="fw-bold text-success">
        {{ $row->total_score }}
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted">
        No candidates found
    </td>
</tr>
@endforelse
</tbody>

</table>

</div>
</div>

</div>

</x-slot>
</x-layout_recruiter>
