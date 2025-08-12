@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">All Companies</h4>
                        <form action="{{ route('companies') }}" method="GET" class="d-flex w-50">
                            <input type="text" name="search" class="form-control me-2 rounded-pill"
                                placeholder="Search companies..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light rounded-pill">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        @if ($companies->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered text-left">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Company Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companies as $company)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}
                                                </th>
                                                <td>
                                                    <a href="/companies/{{ $company->id }}" class="text-decoration-none">
                                                        {{ $company->company_name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $companies->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="alert alert-info text-center" role="alert">
                                @if (request('search'))
                                    No companies found matching "{{ request('search') }}".
                                @else
                                    No companies found.
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
