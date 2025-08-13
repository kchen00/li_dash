@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">All Semesters</h4>

                        <form action="{{ route('semesters') }}" method="GET" class="d-flex w-50">
                            <input type="text" name="search" class="form-control me-2 rounded-pill"
                                placeholder="Search semesters..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light rounded-pill">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        @if ($semesters->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered text-left">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($semesters as $semester)
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
                                    @endforeach
                                </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $semesters->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="alert alert-info text-center" role="alert">
                                @if (request('search'))
                                    No semesters found matching "{{ request('search') }}".
                                @else
                                    No semesters found.
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
