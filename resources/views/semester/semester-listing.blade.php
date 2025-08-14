@extends('layouts.app')

@section('content')
<div class="container my-5">

    {{-- Page Title --}}
    <h2 class="mb-4">Semester Listing</h2>

    {{-- Search Form and "Add New Semester" Button --}}
    <div class="row align-items-center mb-4">
        {{-- Search Form --}}
        <div class="col-md-6">
            <form action="{{ route('semesters') }}" method="GET" class="d-flex">
                <input
                    type="text"
                    name="search"
                    class="form-control me-2 rounded-pill"
                    placeholder="Search semesters..."
                    value="{{ request('search') }}"
                    aria-label="Search semesters"
                >
                <button type="submit" class="btn btn-light rounded-pill">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </form>
        </div>

        {{-- Add New Semester Button --}}
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('semesters.create') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-plus me-1"></i> Add New Semester
            </a>
        </div>
    </div>


    {{-- Semesters Table --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($semesters as $semester)
                    <tr>
                        <th scope="row">
                            {{ ($semesters->currentPage() - 1) * $semesters->perPage() + $loop->iteration }}
                        </th>
                        <td>
                            <a href="{{ route('semesters.getById', ['id' => $semester->id]) }}" class="text-decoration-none">
                                Semester {{ $semester->semester_number == 1 ? "I" : "II" }} Academic Session ({{ $semester->start_year }}/{{ $semester->end_year }})
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No semesters found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $semesters->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
