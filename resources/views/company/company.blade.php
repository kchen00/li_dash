@extends('layouts.app')

@section('content')
    <!-- This view is for displaying a single company's details. -->
    <!-- It expects a $company variable to be passed from the controller. -->

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">{{ $company->company_name }} Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>General Information</h5>
                                <hr>
                                <p><strong>Company Name:</strong> {{ $company->company_name }}</p>
                                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                                <p><strong>Location:</strong> {{ $company->city }}, {{ $company->country }}</p>
                                <p><strong>Total Hires:</strong> {{ $company->hiring_count }}</p>
                                <!-- You can add more company details here -->
                            </div>
                            <div class="col-md-6">
                                <h5>Historic Hiring Data</h5>
                                <hr>
                                <!-- This is where you would place your data visualization components, -->
                                <!-- such as a chart showing hiring trends over the years. -->
                                <div class="alert alert-info text-center" role="alert">
                                    Chart will go here.
                                </div>
                            </div>
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
