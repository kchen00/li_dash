@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h1>
                    Top {{ count($top_company) }} hiring companies for 
                    @if(is_null($selected_semester))
                        ALL SEMESTERS
                    @else 
                        SEM {{ $selected_semester->semester_number }} {{ $selected_semester->start_year }}/{{ $selected_semester->end_year }}
                    @endif
                </h1>
            </div>
            <div class="col-auto">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Select semester
                </button>
                <ul class="dropdown-menu">
                    <a class="dropdown-item" href="/company_id={{ $selected_company->id }}/semester_id=0">ALL SEMESTERS</a>
                    @foreach ($semesters as $semester)
                        <a class="dropdown-item" href="/company_id={{ $selected_company->id }}/semester_id={{ $semester->id }}">SEM {{ $semester->semester_number }}
                            {{ $semester->start_year }}/{{ $semester->end_year }}</a>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row row-cols-auto justify-content-start">
            @foreach ($top_company as $top)
                <div class="col-auto btn btn-lg btn-outline-info btn-border-5 rounded m-2 text-center"
                    title="Click to visit this company">
                    <a href="/company_id={{ $top->id }}/semester_id=@if(is_null($selected_semester)){{ 0 }}@else{{ $selected_semester->id }}@endif" class="text-decoration-none text-white">
                        <p class="fs-5 fw-bold">{{ $top->company_name }}</p>
                        <p class="fs-1">{{ $top->students_count }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row my-4 justify-content-center">
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
                        <li>
                            <a class="dropdown-item" href="{{ route('students_per_semester_per_company', ['company_id' => $company->id, 'semester_id'=>0]) }}">
                                {{ $company->company_name }} ({{ count($company->students) }})
                            </a>
                        </li>
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
        const data = <?php echo json_encode($data); ?>;

        console.log(data);

        const semester_names = [];
        const student_counts = [];

        for (const semester in data) {
            semester_name = data[semester]["semester_name"];
            semester_names.push(semester_name);

            student_count = Object.keys(data[semester]).length - 1;
            student_counts.push(student_count);
        }

        new Chart(ctx, {
            type: 'bar',
            label: "Students per semester",
            data: {
                labels: semester_names, // X-axis labels
                datasets: [{
                    label: 'Total Students',
                    data: student_counts, // Y-axis data
                    backgroundColor: ["yellow"]
                }]
            },
            options: {
                devicePixelRatio: 1,
                responsive: false,
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
