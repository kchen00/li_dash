@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Company Title -->
            <div class="mb-4 border-bottom pb-2 text-center">
                <h2 class="fw-bold">{{ $company->name }}</h2>
            </div>

            <!-- Historic Hiring Data -->
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Historic Hiring Data</h4>
                    <span><strong>Total Hires:</strong> {{ sizeof($hiredStudents) }}</span>
                </div>

                @if(empty($hiringByYear) || count($hiringByYear) === 0)
                    <div class="alert alert-secondary text-center">No hiring data available yet.</div>
                @else
                    <div class="d-flex justify-content-center">
                        <div style="height: 400px; width: 100%;">
                            <canvas id="hiringChart"></canvas>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Hired Students -->
            <div class="mb-4">
                <h4 class="mb-3">Hired Students</h4>
                <hr>
                @if ($hiredStudents->isEmpty())
                    <p class="text-muted fst-italic">No students have been hired by this company yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Hired Semester</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hiredStudents as $student)
                                    <tr>
                                        <td>{{ $student->student_id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            Semester {{ $student->semester->semester_number == 1 ? 'I' : 'II' }} Academic Session ({{ $student->semester->start_year }}/{{ $student->semester->end_year }})
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="text-end mt-4">
                <a href="{{ route('companies') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Companies
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const hiringData = @json($hiringByYear);
    if(Object.keys(hiringData).length > 0) {
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
                    backgroundColor: 'yellow',
                    borderColor: 'rgba(0, 0, 0, 0.6)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Number of Students Hired Per Year',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
