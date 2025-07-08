@extends('admin.layout.master')
@section('content')
    <h1>Applicant Data</h1>
    <p><strong>Serial Number:</strong> {{ $applicantData['applicant_serial_number'] ?? 'N/A' }}</p>
    <p><strong>Surname:</strong> {{ $applicantData['surname'] ?? 'N/A' }}</p>
    <p><strong>Other Names:</strong> {{ $applicantData['other_names'] ?? 'N/A' }}</p>
    <p><strong>Qualification:</strong> {{ $applicantData['qualification'] ?? 'N/A' }}</p>
    <p><strong>Age:</strong> {{ $applicantData['age'] ?? 'N/A' }} Years</p>
    @if (!empty($applicantData['applicant_image']))
        <p><strong>Applicant Image:</strong></p>
        <img src="{{ asset($applicantData['applicant_image']) }}" alt="Applicant Image"style="max-width: 300px;">
    @else
        <p>No image available.</p>
    @endif
@endsection
