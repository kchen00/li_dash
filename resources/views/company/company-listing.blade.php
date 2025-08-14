@extends('layouts.app')

@section('content')
<div class="container my-5">

    {{-- Page Title --}}
    <h2 class="mb-4">Company Listing</h2>

    {{-- Search Form --}}
    <form action="{{ route('companies') }}" method="GET" class="d-flex w-50 mb-4">
        <input type="text" name="search" class="form-control me-2 rounded-pill"
               placeholder="Search companies..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-light rounded-pill">
            <i class="fas fa-search me-1"></i> Search
        </button>
    </form>

    {{-- Companies Table --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr>
                        <th scope="row">
                            {{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}
                        </th>
                        <td>
                            <a href="/companies/{{ $company->id }}" class="text-decoration-none">
                                {{ $company->name }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $companies->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
