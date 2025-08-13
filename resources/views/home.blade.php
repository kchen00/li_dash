@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h1>
                    Top {{ count($topCompany) }} hiring companies for ALL SEMESTERS
                </h1>
            </div>
        </div>
        <div class="row row-cols-auto justify-content-start">
            @foreach ($topCompany as $top)
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
    <div class="text-center" role="alert">
        <div>
            <canvas id="hiringChart" style="height:400px;"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const hiringData = @json($hiringByYear);
        const labels = Object.keys(hiringData);
        const data = Object.values(hiringData);

        const ctx = document.getElementById('hiringChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Hires per Year',
                    data: data,
                    backgroundColor: "yellow"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0 // if you want integer ticks
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Number of students hired per year'
                    }
                }
            }
        });
    </script>

@endpush
