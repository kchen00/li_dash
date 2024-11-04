@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row align-items-center">
        <div class="col">
            <h1>{{ $selected_company->company_name }}</h1>
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Select Company
                </button>
                <ul class="dropdown-menu">
                    @foreach ($companies as $company)
                        <li><a class="dropdown-item"
                                href="{{ route('home', ['company_id' => $company->id]) }}">{{ $company->company_name }}
                                ({{ count($company->students) }})
                            </a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <canvas id="student_count"></canvas>
    </div>

    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Semester</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>SEM {{ $student->semester->semester_number }}
                            {{ $student->semester->start_year }}/{{ $student->semester->end_year }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const ctx = document.getElementById('student_count');
        const studentCountData = @json($student_count);

        const semesterIds = studentCountData.map(item => item.semester_id);
        const totalStudents = studentCountData.map(item => item.total_students);

        console.log('Semester IDs:', semesterIds);
        console.log('Total Students:', totalStudents);

        new Chart(ctx, {
            type: 'bar',
            label: "Students per semester",
            data: {
                labels: semesterIds, // X-axis labels
                datasets: [{
                    label: 'Total Students',
                    data: totalStudents, // Y-axis data
                }]
            },
            options: {
                barThickness: 100,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Number of student per semester'
                    }
                },
            },
        });
    </script>
@endsection
