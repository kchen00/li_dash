@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">{{ $company->company_name }} Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h5>Historic Hiring Data</h5>
                            <p><strong>Total Hires:</strong>{{ sizeof($hiredStudents) }}</p>
                            <div class="text-center" role="alert">
                                <div>
                                    <canvas id="hiringChart" style="height:400px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Hired Students</h5>
                            <hr>
                            @if ($hiredStudents->isEmpty())
                                <p>No students have been hired by this company yet.</p>
                            @else
                                <table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Hired Year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hiredStudents as $student)
                                            <tr>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->semester->start_year }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('companies') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Companies
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const hiringData = @json($hiringByYear);

        const labels = hiringData.map(item => item.year);
        const data = hiringData.map(item => item.students);

        const ctx = document.getElementById('hiringChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Hires per Year',
                    data: data,
                    backgroundColor: ["yellow"]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Number of student per semester'
                    }
                }
            }
        });
    </script>
@endpush
