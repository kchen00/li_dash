@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h1>
                    Top {{ count($top_company) }} hiring companies for
                    @if (is_null($selected_semester))
                        ALL SEMESTERS
                    @else
                        SEM {{ $selected_semester->semester_number }}
                        {{ $selected_semester->start_year }}/{{ $selected_semester->end_year }}
                    @endif
                </h1>
            </div>
        </div>
        <div class="row row-cols-auto justify-content-start">
            @foreach ($top_company as $top)
                <div class="col-auto btn btn-lg btn-outline-info btn-border-5 rounded m-2 text-center"
                title="Click to visit this company">
                <a href="{{ route('companies.getById', ['id' => $top->id]) }}"
                    class="text-decoration-none text-white">
                    <p class="fs-5 fw-bold">{{ $top->company_name }}</p>
                    <p class="fs-1">{{ $top->students_count }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection
