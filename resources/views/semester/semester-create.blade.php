@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add New Semester</h2>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Semester creation form --}}
    <form action="{{ route('semesters.store') }}" method="POST">
        @csrf

        {{-- Semester Number --}}
        <div class="mb-3">
            <label for="semester_number" class="form-label">Semester Number</label>
            <select name="semester_number" id="semester_number" class="form-select" required>
                <option value="" disabled selected>Select semester</option>
                <option value="1" {{ old('semester_number') == 'I' ? 'selected' : '' }}>I</option>
                <option value="2" {{ old('semester_number') == 'II' ? 'selected' : '' }}>II</option>
            </select>
        </div>

        {{-- Start Year --}}
        <div class="mb-3">
            <label for="start_year" class="form-label">Start Year</label>
            <input type="number" name="start_year" id="start_year" class="form-control"
                   value="" required min="2000" max="2100" placeholder="e.g., 2025" oninput="document.getElementById('end_year').value = parseInt(this.value) + 1;">
        </div>

        {{-- End Year --}}
        <div class="mb-3">
            <label for="end_year" class="form-label">End Year</label>
            <input type="number" name="end_year" id="end_year" class="form-control"
                   value="{{ old('end_year') }}" required min="2000" max="2100" readonly>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary rounded-pill">
            <i class="fas fa-save me-1"></i> Save Semester
        </button>

        {{-- Optional: Cancel Button --}}
        <a href="{{ route('semesters') }}" class="btn btn-secondary rounded-pill ms-2">Cancel</a>
    </form>
</div>
@endsection
