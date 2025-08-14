@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Upload new data</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @error('error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    {{-- Upload Instructions --}}
    <div class="alert alert-info p-4 mb-4">
        <h5>Upload Instructions</h5>
        <ol>
            <li><strong>Create a new semester</strong> first before uploading the CSV file.</li>
            <li><strong>Prepare the CSV file carefully:</strong></li>
            <ul>
                <li>The CSV file <strong>must include these headers</strong> exactly: <code>STUDENT ID</code>, <code>STUDENT NAME</code>, and <code>COMPANY NAME</code>.</li>
                <li>Ensure <strong>all rows have values matching the headers</strong> — no missing or extra columns.</li>
            </ul>
            <li>Once your CSV file is clean and verified, <strong>upload it using the form below.</strong></li>
        </ol>
    </div>

    {{-- Upload Form --}}
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="semester_id" class="form-label">Select Semester</label>
            <select name="semester_id" id="semester_id" class="form-control" required>
                @foreach($semesters as $semester)
                    <option value="{{ $semester->id }}">
                        Semester {{ $semester->semester_number == 1 ? "I" : "II" }}
                        Academic Session ({{ $semester->start_year }}/{{ $semester->end_year }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="csv_file" class="form-label">Choose CSV file</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload and Read</button>
    </form>
</div>
@endsection
